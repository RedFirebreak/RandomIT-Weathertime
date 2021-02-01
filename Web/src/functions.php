<?php
// Refresh $rootpath
$ROOTPATH = GetRootPath();

/**
 * This function makes sure user input is stored safely in the database.
 *
 * @param $userinput
 * @return string|void
 * @author Stefan Jilderda
 */

function cleanUserInput($userinput) {
    $dbConnection = databaseConnect();
    if (empty($userinput)) {
        return;
    } else {
        $userinput = htmlspecialchars($userinput);
        $userinput = mysqli_real_escape_string($dbConnection, $userinput);
    }
    databaseDisconnect($dbConnection); // disconnect from database
    return $userinput;
}

/**
 * Decodes user input
 * @param $userinput
 * @return string
 * @author Stefan Jilderda
 */

function decodeUserInput($userinput) {
    $userinput = htmlspecialchars_decode($userinput);
    return $userinput;
}

/**
 * Used to connect to the database.
 *
 * @return false|mysqli
 * @author Stefan Jilderda
 */
function databaseConnect() {
    global $config;

    // Only open database connection if we actually have one
        //connect to database
        $db_conn = mysqli_connect(
            $config['mysql']['hostname'],
            $config['mysql']['username'],
            $config['mysql']['password'],
            $config['mysql']['database'],
            $config['mysql']['port']
        );

        // check connection
        if (mysqli_connect_errno()) {
            //Throw error (Cant save in database, cuz no connection.)
            $errordate = date("j-n-Y");
            $errortime = date("h:i:s");
            $docname = basename(__FILE__);
            $errormessage = "$errortime | $docname | FAILED DATABASE CONNECTION: " . mysqli_connect_error() . "\n";

            // Write in the main logging file
            $dbconnectionerrorfile = fopen("src/logs/{$errordate}_AllLogs.log", "a");
            fwrite($dbconnectionerrorfile, $errormessage);
            fclose($dbconnectionerrorfile);

            // Write seperate file
            $dbconnectionerrorfile = fopen("src/logs/filtered/{$errordate}_db-fail.log", "a");
            fwrite($dbconnectionerrorfile, $errormessage);
            fclose($dbconnectionerrorfile);

            // Inform the user of the error
            echo "<h1>The database connection has failed.<br>";
            echo "<p>The admins have been notified of this error. Please come back later!</p>";
            echo "<br>";
            exit();
        }
        //echo "connected";
        return $db_conn;
}

/**
 * Used to disconnect from the database.
 *
 * @param $db_conn the database connection
 * @author Stefan Jilderda
 */
function databaseDisconnect($db_conn) {
        mysqli_close($db_conn);
}

/**
 * Scans a directory and returns an array of unique station ids
 *
 * @return array
 * @author Jens Maas
 */

function findTotalNumStations() {
    $total = [];
    $finishedArray = [];
    global $DIR;
    $files = scandir($DIR, SCANDIR_SORT_DESCENDING);
 
    foreach($files as $file) {
        $expl = explode('-', $file);
        if (sizeof($expl) > 1) {
            array_push($total, intval($expl[0]));
        }
    }
    //print_r(array_unique($total, SORT_NUMERIC));
    $unique = array_unique($total, SORT_NUMERIC);
    foreach($unique as $stationID) {
        array_push($finishedArray, $stationID);
    }
    return $finishedArray;
 }

/**
 * This function queries the data needed to place the markers on the map
 * and returns it in an array.
 *
 * @param $stationIDArray
 * @return array
 * @author Teun de Jong & Jens Maas
 */
 function placeMarkers($stationIDArray) {

     $conn = databaseConnect();
 
     if ($conn->connect_error) {
         die("Database connection failed! " . $conn->connect_error);
     }
     $sql = "SELECT stn FROM stations";
     $result = $conn->query($sql);
 
     $tempResult = [];
     if ($result->num_rows > 0) {
       // output data of each row
       while($row = $result->fetch_assoc()) {
         array_push($tempResult, $row["stn"]);
         //echo "id: " . $row["stn"]."<br>";
       }
     } else {
       echo "0 results";
     }
 
     $jambek = array_intersect($tempResult, $stationIDArray);
 
     $locationData = [];
 
     foreach($jambek as $station) {
         $sql2 = "SELECT stn, name, country, longitude, latitude FROM stations WHERE stn = '$station'";
         $result2 = $conn->query($sql2);
         if ($result2->num_rows > 0) {
             // output data of each row
             while($row = $result2->fetch_assoc()) {
                 array_push($locationData, [$row["name"], $row["stn"], $row["country"], $row["longitude"], $row["latitude"]]);
             }
         } else {
             echo "0 results";
         }
     }
 
     $conn->close();
     return $locationData;
 }

/**
 * Function used to return the latest JSON file for the respective station.
 * @param $wantedStationIDs array containing the station ids for the wanted
 *                          json files.
 * @return array containing the latest json files.
 * @author Jens Maas
 */
 function retrieveLatestJSON($wantedStationIDs) {
     global $DIR;
     $temp_array = [];
     $files = scandir($DIR, SCANDIR_SORT_ASCENDING);
     //print_r($files);
 
     foreach($wantedStationIDs as $stationID) {
         $placeholderTime = 0;
         $placeholderStation = 0;
         $fileholder = NULL;
         $tempJson = NULL;
         $jsonFile = NULL;
         foreach($files as $file) {
             //echo $file;
             $expl = explode('-', $file);
             if (sizeof($expl) > 1) { // Catch nullpointer
                 if(intval($stationID) == intval($expl[0])) {
                     if($expl[1] > $placeholderTime) {
                         //echo $placeholder . " vervangen met: " . $expl[1] . "<br>";
                         //echo $fileholder . " vervangen met: " . $file . "<br>";
                         $placeholderTime = $expl[1];
                         $placeholderStation = $expl[0];
                         $fileholder = $file;
                     }
                 }
             }
         }
         $tempJson = file_get_contents($DIR . $fileholder);
         $jsonFile = json_decode($tempJson, true);
         array_push($temp_array, $jsonFile);
         //$temp_array[$placeholderStation] = $placeholderTime


     }
     return $temp_array;
 }

/**
 * Function to retrieve all .json files for the wanted station going back
 * $days
 *
 * @param $wantedStationID
 * @param $days amount of days back in time
 * @return array an array of all .json files.
 * @author Jens Maas
 */

 function retrieveJSONsPerStation($wantedStationID, $days) {
     global $DIR; // Defined in config
     $temp_array = [];
 
     $files = scandir($DIR, SCANDIR_SORT_DESCENDING);
 
     // Stap door elke file in de dir
     foreach($files as $file) {
         $expl = explode('-', $file); // Cut the ID and timestamp
         if (sizeof($expl) > 1) {
             if(intval($wantedStationID) == intval($expl[0])) {
 
                 // Calculate the timedata of
                 $time = round(intval($expl[1]) / 1000);
 
                 if ($time > $days * 86400) {
 
                 // This saves the file as a json object in the array
                 $tempJson = file_get_contents($DIR . $file);
                 $jsonFile = json_decode($tempJson, true);
 
                 array_push($temp_array, $jsonFile);
                 }
             }
         }
     }
     return $temp_array;
 }

/**
 * Function to retrieve all data of a specific station and type.
 * @param $stationID
 * @param $days amount of days back in time.
 * @param $datatype type of data wanted. i.e. 'Temperature' or 'Windspeed'
 * @return array containing all data of a station of that specific type.
 * @author Jens Maas
 */

 function retrieveData($stationID, $days, $datatype) {
     $tempArray = retrieveJSONsPerStation($stationID, $days);
     $tempReturn = [];
     foreach($tempArray as $tempVar) {
         array_push($tempReturn, $tempVar[$datatype]);
     }
     return $tempReturn;
 }

/**
 * Function to extrapolate a missing datapoint by going back a maximum of
 * 30 datapoints.
 *
 * @param $stationID
 * @param $days amount of days back in time
 * @param $dataType the wanted datatype
 * @return float|int|mixed|string
 * @author Teun de Jong & Stefan Kuppen
 */
function extrapolate($stationID, $days, $dataType){
    $counter = 0;
    $JSONS = retrieveData($stationID, $days, $dataType);
    $temp = $JSONS[0];
    $last = 0;
    $diff = 0;

    foreach ($JSONS as $value) {
        $last = $value;
        if ($counter == 0){
            $counter++;
        }
        if ($value == 'true') return 'Yes';
        if ($value == 'false') return 'No';

        else if ($counter == 30){
            $diff = $diff / $counter;
            $diff += $last;
            return $diff;

        }
        else if (is_numeric($temp)) {
            $diff += $value - $temp;
            $temp = $value;
            $counter++;
        }

    }
    $diff = $diff / $counter;
    $diff += $last;
    return $diff;
}
?>