<?php
//Refresh $rootpath
$ROOTPATH = GetRootPath();

//Always and I mean ALWAYS use this function while dealing with user input to make sure it gets stored savely in the database
function cleanUserInput($userinput) {
    $dbConnection = databaseConnect();
    if (empty($userinput)) {
        return;
    } else {
        $userinput = htmlspecialchars($userinput);
        $userinput = mysqli_real_escape_string($dbConnection, $userinput);
    }
    databaseDisconnect($dbConnection); //Disconnect from database
    return $userinput;
}


//Decode *potentially HARMFUL* data from the database
function decodeUserInput($userinput) {
    return htmlspecialchars_decode($userinput);
}

function databaseConnect() {
    global $config;

    //Only open database connection if we actually have one
        //Connect to database
        $db_conn = mysqli_connect(
            $config['mysql']['hostname'],
            $config['mysql']['username'],
            $config['mysql']['password'],
            $config['mysql']['database'],
            $config['mysql']['port']
        );

        // check connection
        if (mysqli_connect_errno()) {
            //Throw error (Cannot save in database, because there is no connection)
            $errordate = date("j-n-Y");
            $errortime = date("h:i:s");
            $docname = basename(__FILE__);
            $errormessage = "$errortime | $docname | FAILED DATABASE CONNECTION: " . mysqli_connect_error() . "\n";

            //Write in the main logging file
            $dbconnectionerrorfile = fopen("src/logs/{$errordate}_AllLogs.log", "a");
            fwrite($dbconnectionerrorfile, $errormessage);
            fclose($dbconnectionerrorfile);

            //Write seperate file
            $dbconnectionerrorfile = fopen("src/logs/filtered/{$errordate}_db-fail.log", "a");
            fwrite($dbconnectionerrorfile, $errormessage);
            fclose($dbconnectionerrorfile);

            //Inform the user of the error
            echo "<h1>The database connection has failed.<br>";
            echo "<p>The admins have been notified of this error. Please come back later!</p>";
            echo "<br>";
            exit();
        }
        return $db_conn;
}

function databaseDisconnect($db_conn) {
        mysqli_close($db_conn);
}

function toString($array) {
    $string = implode(" ", $array);
    return "$string";
}

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
    $unique = array_unique($total, SORT_NUMERIC);
    foreach($unique as $stationID) {
        array_push($finishedArray, $stationID);
    }
    return $finishedArray;
}

function placeMarkers($stationIDArray) {

    global $config;
    $servername = $config['mysql']['hostname'];
    $username = $config['mysql']['username'];
    $password = $config['mysql']['password'];
    $dbname = $config['mysql']['database'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database connection failed! " . $conn->connect_error);
    }
    $sql = "SELECT stn FROM stations";
    $result = $conn->query($sql);

    $tempResult = [];
    if ($result->num_rows > 0) {
       //Output data of each row
    while($row = $result->fetch_assoc()) {
        array_push($tempResult, $row["stn"]);
    }
} else {
    echo "0 results";
    }

    $tempArray = array_intersect($tempResult, $stationIDArray);

    $locationData = [];

    foreach($tempArray as $station) {
        $sql2 = "SELECT stn, name, country, longitude, latitude FROM stations WHERE stn = '$station'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            //Output data of each row
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


function retrieveLatestJSON($wantedStationIDs) {
    global $DIR;
    $tempArray = [];
    $files = scandir($DIR, SCANDIR_SORT_ASCENDING);

    foreach($wantedStationIDs as $stationID) {
        $placeholderTime = 0;
        $fileholder = NULL;
        $tempJson = NULL;
        $jsonFile = NULL;
        foreach($files as $file) {
            $expl = explode('-', $file);
            if ((sizeof($expl) > 1) && (intval($stationID) == intval($expl[0])) && ($expl[1] > $placeholderTime)) {
                $placeholderTime = $expl[1];
                $fileholder = $file;
            }
        }
        $tempJson = file_get_contents($DIR . $fileholder);
        $jsonFile = json_decode($tempJson, true);
        array_push($tempArray, $jsonFile);
    }
    return $tempArray;
}

// This function is called to read all .json files in the $DIR folder
// $wantedStationID is the ID from the weatherstation you want data from
// Next all .json files are put into an array
function retrieveJSONsPerStation($wantedStationID, $days) {
    global $DIR; //Defined in config
    $tempArray = [];

    $files = scandir($DIR, SCANDIR_SORT_DESCENDING);

    //Walk through each file in the DIR
    foreach($files as $file) {
        $expl = explode('-', $file); //Cut the ID and timestamp
        if ((sizeof($expl) > 1) && (intval($wantedStationID) == intval($expl[0]))) {
            //Calculate the timedata
            $time = round(intval($expl[1]) / 1000);

            if ($time > $days * 86400) {
            //This saves the file as a .json object in the array
            $tempJson = file_get_contents($DIR . $file);
            $jsonFile = json_decode($tempJson, true);

            array_push($tempArray, $jsonFile);
            }
        }
    }
    return $tempArray;
}

//This function is uses the function retrieveJSONsPerStation()
//Next you give the amount of past days and a datatype to search for
//It then returns an array with all data of that specific data in the specified time
function retrieveData($stationID, $days, $datatype) {
    $tempArray = retrieveJSONsPerStation($stationID, $days);
    $tempReturn = [];
    foreach($tempArray as $tempVar) {
        array_push($tempReturn, $tempVar[$datatype]);
    }
    return $tempReturn;
}

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
        if ($value == 'true') {
            return 'Yes';
        } elseif ($value == 'false') {
            return 'No';
        } elseif ($counter == 30){
            return $last + ($diff / $counter);
        } elseif (is_numeric($temp)) {
            $diff += $value - $temp;
            $temp = $value;
            $counter++;
        }
    }
    return $last + ($diff / $counter);
}

?>