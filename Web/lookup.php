<!DOCTYPE html>
<html lang="nl">

<head>

    <?php require "./pages/header.php" ?>

    <title>RandomIT - Lookup</title>
</head>

<body>

    <?php
    // if the user is logged in, send him to the dashboard!
    require "$ROOTPATH/pages/navigation.php";

    if (isset($_GET['id'])) {
        echo " ID = " . $_GET['id'];
    } else {
        echo "NO ID SET";
    }
    ?>
    
    <?php

    require "$ROOTPATH/src/functions.php";

    //Data opvragen via functie, GET voor het stations-ID, dag 1, DataType.
    //Integer data
    $retrievedDataTemperature = json_encode(retrieveData($_GET['id'], 1, 'Temperature'));
    $retrievedDataDewPoint = json_encode(retrieveData($_GET['id'], 1, 'DewPoint'));
    $retrievedDataPercipitation = json_encode(retrieveData($_GET['id'], 1, 'Percipitation'));
    $retrievedDataSnowDrop = json_encode(retrieveData($_GET['id'], 1, 'SnowDrop'));
    $retrievedDataWindspeed = json_encode(retrieveData($_GET['id'], 1, 'Windspeed'));
    $retrievedDataWindDirection = json_encode(retrieveData($_GET['id'], 1, 'WindDirection'));
    $retrievedDataCloudCoverage = json_encode(retrieveData($_GET['id'], 1, 'CloudCoverage'));
    $retrievedDataVisibility = json_encode(retrieveData($_GET['id'], 1, 'Visibility'));
    $retrievedDataStationPressure = json_encode(retrieveData($_GET['id'], 1, 'StationLevelPressure'));
    $retrievedDataSeaPressure = json_encode(retrieveData($_GET['id'], 1, 'SeaLevelPressure'));

    //Boolean data
    $retrievedDataStorm = json_encode(retrieveData($_GET['id'], 1, 'Storm'));
    $retrievedDataSnow = json_encode(retrieveData($_GET['id'], 1, 'Snow'));
    $retrievedDataRain = json_encode(retrieveData($_GET['id'], 1, 'Rain'));
    $retrievedDataTornado = json_encode(retrieveData($_GET['id'], 1, 'Tornado'));
    $retrievedDataFreeze = json_encode(retrieveData($_GET['id'], 1, 'Freeze'));
    $retrievedDataHail = json_encode(retrieveData($_GET['id'], 1, 'Hail'));

    ?>

    <div id="test">
    <script type="text/javascript"> 
        function toFloat(arrayDataString){
            for (i=0; i<arrayDataString.length; i++) {
                arrayDataString[i] = parseFloat(arrayDataString[i]);
            }
            return arrayDataString;
        }
        
        //Integer data
        var passedDataArrayTemperature =  JSON.parse(toFloat('<?php echo $retrievedDataTemperature; ?>')); 
        var passedDataArrayDewPoint =  JSON.parse(toFloat('<?php echo $retrievedDataDewPoint; ?>'));
        var passedDataArrayPercipitation =  JSON.parse(toFloat('<?php echo $retrievedDataPercipitation; ?>'));
        var passedDataArraySnowdrop =  JSON.parse(toFloat('<?php echo $retrievedDataSnowDrop; ?>'));
        var passedDataArrayWindspeed =  JSON.parse(toFloat('<?php echo $retrievedDataWindspeed; ?>'));
        var passedDataArrayWindDirection =  JSON.parse(toFloat('<?php echo $retrievedDataWindDirection; ?>'));
        var passedDataArrayCloudCoverage =  JSON.parse(toFloat('<?php echo $retrievedDataCloudCoverage; ?>'));
        var passedDataArrayVisibility =  JSON.parse(toFloat('<?php echo $retrievedDataVisibility; ?>')); 
        var passedDataArrayStationPressure =  JSON.parse(toFloat('<?php echo $retrievedDataStationPressure; ?>'));
        var passedDataArraySeaPressure =  JSON.parse(toFloat('<?php echo $retrievedDataSeaPressure; ?>')); 

        //Boolean data
        var passedDataArrayStorm =  JSON.parse('<?php echo $retrievedDataStorm; ?>');
        var passedDataArraySnow =  JSON.parse('<?php echo $retrievedDataSnow; ?>'); 
        var passedDataArrayRain =  JSON.parse('<?php echo $retrievedDataRain; ?>'); 
        var passedDataArrayTornado =  JSON.parse('<?php echo $retrievedDataTornado; ?>');
        var passedDataArrayFreeze = JSON.parse('<?php echo $retrievedDataFreeze; ?>');
        var passedDataArrayHail =  JSON.parse('<?php echo $retrievedDataHail; ?>'); 
        
        //Printing the passed array elements for test
        document.write(passedDataArrayTemperature  + "<br>");
        document.write(passedDataArrayDewPoint  + "<br>");
        document.write(passedDataArrayWindDirection  + "<br>");
        document.write(passedDataArrayFreeze  + "<br>");
        document.write(passedDataArrayStorm  + "<br>");


    </script>
    </div>
</body>

<footer>
    <?php
        require "./pages/footer.php";
    ?>

</footer>

</html>