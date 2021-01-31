<?php
// Refresh $rootpath
$ROOTPATH = GetRootPath();

// Always and I mean ALWAYS use this function while dealing with user input to make sure it gets stored savely in the database.
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


// Decode *potentially HARMFULL* data from the database
function decodeUserInput($userinput) {
    $userinput = htmlspecialchars_decode($userinput);
    return $userinput;
}

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

function databaseDisconnect($db_conn) {
        mysqli_close($db_conn);
}

function datesFormatting($databasedate) {
    // To be sure, clean the date
    $inputdate = cleanUserInput($databasedate);

    // StroToTime mafs
    $strtotimeinput = strtotime("$inputdate"); //Future date.
    $timeNow = strtotime("now");

    $timeleft = $timeNow - $strtotimeinput; // Future will result in a negative value.

    $leftdays = (int)abs(($timeleft / 24 / 60 / 60)); // Get the amount of days, then cut off numbers after the decimal by casting to int
    $hoursleft = (int)abs((($timeleft / 60 / 60) % 24)); // timeleft in hours, minus every 24 hours
    $minutesleft = (int)abs((($timeleft / 60)) % 60); // Time in minutes, minus every 60 minutes
    $secondsleft = (int)abs($timeleft % 60); // Time in seconds, minus every 60 seconds

    // Formatting for messages
    if ($leftdays != 1) {
        $textdagen = "dagen";
    } else {
        $textdagen = "dag";
    }

    if ($hoursleft != 1) {
        $texturen = "uren";
    } else {
        $texturen = "uur";
    }

    if ($minutesleft != 1) {
        $textminuten = "minuten";
    } else {
        $textminuten = "minuut";
    }

    if ($secondsleft != 1) {
        $textseconden = "seconden";
    } else {
        $textseconden = "seconde";
    }

    if ($timeleft >= 0) { // A negative value means in the future
        $future = false;
    } else {
        $future = true;
    }

    // Format output
    $output = date('d-m-Y H:i:s', $strtotimeinput);
    $outputnow = date('d-m-Y H:i:s', $timeNow);

    // Message
    if ($future) {
        $fullmessage = "Over $leftdays $textdagen, $hoursleft $texturen, $minutesleft $textminuten, $secondsleft $textseconden ";
        $usefullmessage = "Over $leftdays $textdagen, $hoursleft $texturen, $minutesleft $textminuten";
        $daysmessage = "Over $leftdays $textdagen";
    } else {
        $fullmessage = "$leftdays $textdagen, $hoursleft $texturen, $minutesleft $textminuten, $secondsleft $textseconden geleden";
        $usefullmessage = "$leftdays $textdagen, $hoursleft $texturen, $minutesleft $textminuten geleden";
        $daysmessage = "$leftdays $textdagen geleden";
    }

    // Make the array
    $returnarray = array(
        'input' => $inputdate,
        'output' => $output,
        'strtotimeinput' => $strtotimeinput,
        'strtotimenow' => $timeNow,
        'strtotimeleft' => $timeleft,
        'now' => $outputnow,
        'future' => $future,
        'daysfromnow' => $leftdays,
        'hoursfromnow' => $hoursleft,
        'minutesfromnow' => $minutesleft,
        'secondsfromdagen' => $secondsleft,
        'textdagen' => $textdagen,
        'texturen' => $texturen,
        'textminuten' => $textminuten,
        'textseconden' => $textseconden,
        'fullmessage' => $fullmessage,
        'usefullmessage' => $usefullmessage,
        'daysmessage' => $daysmessage,
    );
    return $returnarray;
}


function randomNumber($length) {
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }
    return $result;
}

function toString($array) {
    $string = implode(" ", $array);
    return "$string";
}

// Start Jens & Teun functions here
function findTotalNumStations() {
    $total = [];
    $finishedArray = [];
    global $DIR;
    $files = scandir($DIR, SCANDIR_SORT_ASCENDING);
 
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
         //echo $station;
         $sql2 = "SELECT stn, name, country, longitude, latitude FROM stations WHERE stn = '$station'";
         $result2 = $conn->query($sql2);
         if ($result2->num_rows > 0) {
             // output data of each row
             while($row = $result2->fetch_assoc()) {
                 array_push($locationData, [$row["name"], $row["stn"], $row["country"], $row["longitude"], $row["latitude"]]);
                 //echo "id: " . $row["stn"] . " name: " . $row["name"] . " country: " . $row['country'] . " longitude: " . $row["longitude"] . " latitude: " . $row["latitude"] . "<br>";
 
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
     $temp_array = [];
     $files = scandir($DIR, SCANDIR_SORT_ASCENDING);
     //print_r($files);
 
     foreach($wantedStationIDs as $stationID) {
         $placeholder = 0;
         $fileholder = NULL;
         $tempJson = NULL;
         $jsonFile = NULL;
         foreach($files as $file) {
             //echo $file;
             $expl = explode('-', $file);
             if (sizeof($expl) > 1) { // Catch nullpointer
                 if(intval($stationID) == intval($expl[0])) {
                     if($expl[1] > $placeholder) {
                         //echo $placeholder . " vervangen met: " . $expl[1] . "<br>";
                         //echo $fileholder . " vervangen met: " . $file . "<br>";
                         $placeholder = $expl[1];
                         $fileholder = $file;
                     }
                 }
             }
         }
        $tempJson = file_get_contents($DIR . $fileholder);
        $jsonFile = json_decode($tempJson, true);
        array_push($temp_array, $jsonFile);
     }
     return $temp_array;
 }
 
 // Deze functie roep je aan om ALLE .json bestanden in de $DIR folder in te lezen.
 // $wantedStationID is het ID van het weerstation waar je de data van wil hebben.
 // Vervolgens worden al deze .json bestanden in een array geplaatst.
 function retrieveJSONsPerStation($wantedStationID, $days) {
     global $DIR; // Defined in config
     $temp_array = [];
 
     $files = scandir($DIR, SCANDIR_SORT_ASCENDING);
 
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
 
 // Deze functie gebruikt de functie retrieveJSONsPerStation()
 // Vervolgens geef je deze een datatype mee waar je naar kan zoeken
 // Vervolgens spuugt deze functie een array uit met alle data van dat specifieke type.
 function retrieveData($stationID, $days, $datatype) {
     $tempArray = retrieveJSONsPerStation($stationID, $days);
     $tempReturn = [];
     foreach($tempArray as $tempVar) {
         array_push($tempReturn, $tempVar[$datatype]);
     }
     return $tempReturn;
 }
?>