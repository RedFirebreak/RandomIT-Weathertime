<!DOCTYPE html>
<html lang="nl">

<head>

    <?php
    require "functions_jens_teun.php";
    ?>

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
    <link rel="stylesheet" href="walid.css" />
    <script src="dist/leaflet.js"></script>
    <script src="dist/leaflet.rotatedMarker.js"></script>
    <link rel="stylesheet" href="src/Icon.Label.css" />
    <script src="src/Icon.Label.js"></script>
    <script src="src/Icon.Label.Default.js"></script>

    <script type="text/javascript">
            var map = L.map('map').setView([30.354086618820002, 30.9578856290658], 3);
            L.tileLayer('iran/{z}/{x}/{y}.jpg', {
                maxZoom: 8,
                minZoom: 2,
                tileSize: 512,
                zoomOffset: -1
            }).addTo(map);

            var Icons = L.Icon.extend({
                options: {
                    shadowUrl: 'Marker/leaf-shadow.png',
                    iconSize: [38, 95],
                    shadowSize: [50, 64],
                    iconAnchor: [22, 94],
                    shadowAnchor: [4, 62],
                    popupAnchor: [-3, -76]
                }
            });


            var testIcon = L.icon({
            iconUrl: 'Marker/marker-icon-2x.png',
            iconSize: [38,95],
            iconAnchor: [22, 94],
            popupAnchor: [-3, -76],
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
            for (i=0; i<markersPoints.length; i++) {

                L.marker([markersPoints[i][4], markersPoints[i][3]], {
                                                icon: testIcon
                                            }).addTo(map)
                                            .bindPopup(`<h1> <b> ${markersPoints[i][0]}, ${markersPoints[i][2]} </b> </h1> <br> \
                                                        <p id="popupdata"> Temperature: ${markersData[i]['Temperature']} <br> \
                                                        Windspeed: ${markersData[i]['Windspeed']}<br> \
                                                        Cloud Coverage: ${markersData[i]['CloudCoverage']}<br> \
                                                        Snow: ${markersData[i]['Snow']} </p><br> \
                                                        <h1>Station Number: ${markersData[i]['StationNumber']} </h1><br>\
                                                        <h3> <a href = 'lookup.php?id=${markersPoints[i][1]}'> More data </a> </h3> \
                                                        `);

            }



        </script>

</body>

<footer>
</footer>

</html>