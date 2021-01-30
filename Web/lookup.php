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
    //print_r(retrieveData("HIER KOMT JE GET VOOR ", 913340 , 1, 'Windspeed'));

    //Data opvragen via functie, GET voor het stations-ID, dag 1, DataType.
    //Integer data
    $retrievedDataTemperature = retrieveData($_GET['id'], 1, 'Temperature');
    $retrievedDataDewPoint = retrieveData($_GET['id'], 1, 'DewPoint');
    $retrievedDataPercipation = retrieveData($_GET['id'], 1, 'Percipation');
    $retrievedDataSnowDrop = retrieveData($_GET['id'], 1, 'SnowDrop');
    $retrievedDataWindspeed = retrieveData($_GET['id'], 1, 'Windspeed');
    $retrievedDataWindDirection = retrieveData($_GET['id'], 1, 'WindDirection');
    $retrievedDataCloudCoverage = retrieveData($_GET['id'], 1, 'CloudCoverage');
    $retrievedDataVisibility = retrieveData($_GET['id'], 1, 'Visibility');
    $retrievedDataStationPressure = retrieveData($_GET['id'], 1, 'StationLevelPressure');
    $retrievedDataSeaPressure = retrieveData($_GET['id'], 1, 'SeaLevelPressure');

    //Boolean data
    $retrievedDataStorm = retrieveData($_GET['id'], 1, 'Storm');
    $retrievedDataSnow = retrieveData($_GET['id'], 1, 'Snow');
    $retrievedDataRain = retrieveData($_GET['id'], 1, 'Rain');
    $retrievedDataTornado = retrieveData($_GET['id'], 1, 'Tornado');
    $retrievedDataFreeze = retrieveData($_GET['id'], 1, 'Freeze');
    $retrievedDataHail = retrieveData($_GET['id'], 1, 'Hail');

    ?>

    <script type="text/javascript"> 
        //Integer data
        var passedDataArrayTemperature =  <?php echo '["' . implode('", "', $retrievedDataTemperature) . '"]'; ?>; 
        var passedDataArrayDewPoint =  <?php echo '["' . implode('", "', $retrievedDataDewPoiny) . '"]'; ?>; 
        var passedDataArrayPercipation =  <?php echo '["' . implode('", "', $retrievedDataPercipation) . '"]'; ?>; 
        var passedDataArraySnowdrop =  <?php echo '["' . implode('", "', $retrievedDataSnowDrop) . '"]'; ?>; 
        var passedDataArrayWindspeed =  <?php echo '["' . implode('", "', $retrievedDataWindspeed) . '"]'; ?>; 
        var passedDataArrayWindDirection =  <?php echo '["' . implode('", "', $retrievedDataWindDirection) . '"]'; ?>; 
        var passedDataArrayCloudCoverage =  <?php echo '["' . implode('", "', $retrievedDataCloudCoverage) . '"]'; ?>; 
        var passedDataArrayVisibility =  <?php echo '["' . implode('", "', $retrievedDataVisibility) . '"]'; ?>; 
        var passedDataArrayStationPressure =  <?php echo '["' . implode('", "', $retrievedDataStationPressure) . '"]'; ?>; 
        var passedDataArraySeaPressure =  <?php echo '["' . implode('", "', $retrievedDataSeaPressure) . '"]'; ?>; 

        //Boolean data
        var passedDataArrayStorm =  <?php echo '["' . implode('", "', $retrievedDataStorm) . '"]'; ?>; 
        var passedDataArraySnow =  <?php echo '["' . implode('", "', $retrievedDataSnow) . '"]'; ?>; 
        var passedDataArrayRain =  <?php echo '["' . implode('", "', $retrievedDataRain) . '"]'; ?>; 
        var passedDataArrayTornado =  <?php echo '["' . implode('", "', $retrievedDataTornado) . '"]'; ?>;
        var passedDataArrayFreeze =  <?php echo '["' . implode('", "', $retrievedDataFreeze) . '"]'; ?>; 
        var passedDataArrayHail =  <?php echo '["' . implode('", "', $retrievedDataHail) . '"]'; ?>;  
        
        // Printing the passed array elements for test
        document.write(passedDataArrayTemperature); 
    </script>

</body>

<footer>
    <?php
        require "./pages/footer.php";
    ?>

</footer>

</html>