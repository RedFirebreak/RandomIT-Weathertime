<?php
require "$ROOTPATH/src/functions.php";
$weatherstation = array();
$temp5 = 0;
$place5 = "";
$temp4 = 0;
$place4 = "";
$temp3 = 0;
$place3 = "";
$temp2 = 0;
$place2 = "";
$temp1 = 0;
$place1 = "";
foreach($weatherstation as $i){
    $retrievedDataTemperature = [];
    $retrievedDataTemperature = retrieveData($weatherstation, 1, 'Temperature');
    foreach($retrievedDataTemperature as $i){
        if($retrievedDataTemperature[$i] > $temp5){
            $temp5 = $retrievedDataTemperature[$i];
            $place5 = $weatherstation[$i];
            if ($retrievedDataTemperature[$i] > $temp4) {
                $temp4 = $retrievedDataTemperature[$i];
                $place4 = $weatherstation[$i];
                if ($retrievedDataTemperature[$i] > $temp3) {
                    $temp3 = $retrievedDataTemperature[$i];
                    $place3 = $weatherstation[$i];
                    if ($retrievedDataTemperature[$i] > $temp2) {
                        $temp2 = $retrievedDataTemperature[$i];
                        $place2 = $weatherstation[$i];
                        if ($retrievedDataTemperature[$i] > $temp1) {
                            $temp1 = $retrievedDataTemperature[$i];
                            $place1 = $weatherstation[$i];
                        }
                    }
                }
            }
        }
    }
}
?>