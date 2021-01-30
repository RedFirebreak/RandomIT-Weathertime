<?php

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

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "unwdmi";

    $conn = new mysqli($servername, $username, $password, $dbname);



    if ($conn->connect_error) {
        die("Krijg allemaal maar de griep! " . $conn->connect_error);
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
            if (sizeof($expl) > 1) {
                //echo "kaasneger";
                if(intval($stationID) == intval($expl[0])) {
                    //echo "kaasneger";
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

    global $DIR;
    $temp_array = [];


    $files = scandir($DIR, SCANDIR_SORT_ASCENDING);

    // stap door elke file in de dir
    foreach($files as $file) {

        $expl = explode('-', $file);
        if (sizeof($expl) > 1) {
            if(intval($wantedStationID) == intval($expl[0])) {

                // bepaal welke data uit de afgelopen x dagen komt.
                $time = round(intval($expl[1]) / 1000);

                if ($time > $days * 86400) {

                // this saves the file as a json object in the array
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

$DIR = 'data/UniversityTeheran/';

?>