<!DOCTYPE html>
<html lang="nl">

<head>

    <?php require "./pages/header.php" ?>

    <title>RandomIT - Homepage</title>
    <style type="text/css">
    .leaflet-container {
        background-color: #c5e8ff;
    }

    body,
    html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }
    </style>
</head>

<body>
    <?php
    function createMarkers(){ //FUNCTION TO READ AND CREATE THE MARKERS
    $dir = 'data';
    $files = scandir($dir, SCANDIR_SORT_ASCENDING);

        // steps through every file in the dir
        foreach($files as $file) {
            echo $file;
            $expl = explode('-', $file);
            if (sizeof($expl) > 1) {
                // bepaal welke data uit de afgelopen x dagen komt.
                $time = round(intval($expl[1]) / 1000);
                echo "poep";
                //if ($time > $days * 86400) {
                  //  $jsonFile = file_get_contents("data/" . $file);

            }
        }
    }
?>
    <?php
    // if the user is logged in, send him to the dashboard!
    require "$ROOTPATH/pages/navigation.php";
    
    if ($Loggedin == false) { ?>
    <!-- Full Page Image Header with Vertically Centered Content -->
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center">
                    <h1 class="font-weight-light whitetext"><b><?php echo $config['sitetile']?></b></h1>
                    <p class="lead">Please log in to view the data</p>
                    <br>
                    <div class="homeloginbutton">
                        <a href="./login.php" class="border border-dark btn btn-primary">Log-in</a>
                    </div>

                    <br>
                </div>
            </div>
        </div>
    </header>
    <?php
    } elseif ($Loggedin == true) {
        // Show map for logged in users   
    ?>
    <style>
    .info {
        padding: 6px 8px;
        font: 14px/16px Arial, Helvetica, sans-serif;
        background: white;
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
    }

    .info h4 {
        margin: 0 0 5px;
        color: #777;
    }

    .legend {
        text-align: left;
        line-height: 18px;
        color: #555;
    }

    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin-right: 8px;
        opacity: 0.7;
    }
    </style>

    <div id="map" style="width: 100%; height: 100%"></div>
    <link rel="stylesheet" href="./src/css/walid.css" />
    <script src="./src/map/dist/leaflet.js"></script>
    <script src="./src/map/dist/leaflet.rotatedMarker.js"></script>
    <link rel="stylesheet" href="src/map/Icon.Label.css" />
    <script src="./src/map/Icon.Label.js"></script>
    <script src="./src/map/Icon.Label.Default.js"></script>

    <script type="text/javascript">
    var map = L.map('map').setView([30.354086618820002, 30.9578856290658], 3);
    L.tileLayer('./src/map/worldimages/{z}/{x}/{y}.jpg', {
        maxZoom: 8,
        minZoom: 2,
        tileSize: 512,
        zoomOffset: -1
    }).addTo(map);

    var Icons = L.Icon.extend({
        options: {
            shadowUrl: './src/map/Marker/leaf-shadow.png',
            iconSize: [38, 95],
            shadowSize: [50, 64],
            iconAnchor: [22, 94],
            shadowAnchor: [4, 62],
            popupAnchor: [-3, -76]
        }
    });


    var testIcon = L.icon({
        iconUrl: './src/map/Marker/marker-icon-2x.png',
        iconSize: [20, 30],
        iconAnchor: [20, 30],
        popupAnchor: [-10, -40]
    });

    <?php
            $s = placeMarkers(findTotalNumStations());
            $s_to_json = json_encode($s);
            $d = retrieveLatestJSON(findTotalNumStations());
            $d_to_json = json_encode($d);
            ?>

    var markersPoints = JSON.parse('<?php echo $s_to_json?>');
    var markersData = JSON.parse('<?php echo $d_to_json?>');

    // alle markers aanmaken in de for loop
    for (i = 0; i < markersPoints.length; i++) {
        for(j = 0; j < markersData.length; j++) {
            if(markersPoints[i][1] == markersData[j]['StationNumber']) {
                L.marker([markersPoints[i][4], markersPoints[i][3]], {
                    icon: testIcon
                }).addTo(map)
                    .bindPopup(`<table style="text-align:left"> <tr> <th> <h5>${markersPoints[i][0]}, ${markersPoints[i][2]} </h5> </th> </tr> \
                                                        <tr> <td> <h6>Station Number </td> <td> <h6>${markersData[j]['StationNumber']} </h6></td> </tr> \
                                                        <tr> <td> <h6>Temperature </td> <td> <h6>${markersData[j]['Temperature']} °C</h6> </td> </tr> \
                                                        <tr> <td> <h6>Windspeed </td> <td> <h6>${markersData[j]['Windspeed']} km/h</h6> </td> </tr> \
                                                        <tr> <td> <h6>Wind Direction </td> <td> <h6>${markersData[j]['WindDirection']} °</h6> </td> </tr> \
                                                        <tr> <td> <h6>Cloud Coverage </td> <td> <h6>${markersData[j]['CloudCoverage']} % </h6> </td> </tr> \
                                                        <tr> <td> <h6>Precipitation </td> <td> <h6>${markersData[j]['Percipitation']} cm </h6> </td> </tr> \
                                                        <tr> <td> <h6> <a href = 'lookup.php?id=${markersPoints[i][1]}'> More data </a> </h6> </td> \
                                                        </table> \
                                                        `);

            }
        }

    }
    </script>

    <?php
    } // Closing tag for logged in users
    ?>
</body>

<footer>
    <?php
        require "./pages/footer.php";
    ?>

</footer>

</html>