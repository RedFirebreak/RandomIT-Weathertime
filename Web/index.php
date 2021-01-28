<!DOCTYPE html>
<html lang="nl">

<head>

    <?php require "./pages/header.php" ?>

    <title>RandomIT - Homepage</title>
    <style type="text/css">
            .leaflet-container{background-color:#c5e8ff;}
            body, html {
                margin: 0;
                padding: 0;
                width:100%;
                height:100%;
            }
        </style>
</head>

<body>
    <?php
    // if the user is logged in, send him to the dashboard!
    require "$ROOTPATH/pages/navigation.php";
    ?>
    <!-- Full Page Image Header with Vertically Centered Content -->
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center">
                    <h1 class="font-weight-light whitetext"><b><?php echo $config['sitetile']?></b></h1>
                    <p class="lead"><?php echo $config['siteslogan'] ?></p>
                    <br>
                    <div class="homeloginbutton">
                        <a href="<?php GetRootPath(); ?>" class="border border-dark btn btn-primary">Log-in</a>
                    </div>

                    <br>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <div class="container">
        <div class="col-md-12 whiteborder ">

        </div>
    </div>
<style>
        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255,255,255,0.8);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
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
    <script>
        var map = L.map('map').setView([30.354086618820002, 30.9578856290658], 3);
        L.tileLayer('worldmap/{z}/{x}/{y}.png', {
            maxZoom: 5,
            minZoom: 3,
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

        var Icons_2 = L.Icon.extend({
            options: {
                iconSize: [30, 50],
                shadowSize: [50, 64],
                iconAnchor: [22, 94],
                shadowAnchor: [4, 62],
                popupAnchor: [-3, -76]
            }
        });

        var markers_icon = new Icons_2 ({ iconUrl: 'Marker/marker-icon-2x.png' });
        L.marker([37.533, 45.038], { icon: markers_icon }).addTo(map)
            .bindPopup("<b>IRAN</b><br />IRAN.").openPopup(); //HIER MARKERS MAKEN
        L.marker([38, 40], { icon: markers_icon }).addTo(map)
            .bindPopup("<b>IRAN2</b><br />IRAN2.").openPopup(); //HIER MARKERS MAKEN
    </script>
</body>

<footer>
    <?php
        require "./pages/footer.php";
    ?>

</footer>

</html>