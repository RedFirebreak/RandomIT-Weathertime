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
    
    if ($Loggedin == false) {
    ?>

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
    <link rel="stylesheet" href="walid.css" />
    <script src="dist/leaflet.js"></script>
    <script src="dist/leaflet.rotatedMarker.js"></script>
    <link rel="stylesheet" href="src/Icon.Label.css" />
    <script src="src/Icon.Label.js"></script>
    <script src="src/Icon.Label.Default.js"></script>
    <script>
        var map = L.map('map').setView([30.354086618820002, 30.9578856290658], 3);
        L.tileLayer('iran/{z}/{x}/{y}.jpg', {
            maxZoom: 8,
            minZoom: 0,
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

    var markers_icon = new Icons_2({
        iconUrl: 'Marker/marker-icon-2x.png'
    });
    L.marker([37.533, 45.038], {
            icon: markers_icon
        }).addTo(map)
        .bindPopup("<h1><b>ORUMIEH</b></h1><br><h3>IRAN</h3><br><h3><a href = 'lookup.php?id=0'>info lookup</a></h3>")
        .openPopup(); //TESTMARKERS FOR THE REHEARSAL
    L.marker([37.467, 49.467], {
            icon: markers_icon
        }).addTo(map)
        .bindPopup("<h1><b>ANZALI</b></h1><br><h3>?IRAN2</h3><br><h3><a href = 'lookup.php?id=1'>info lookup</a></h3>")
        .openPopup();
    L.marker([37.2, 49.633, 37], {
            icon: markers_icon
        }).addTo(map)
        .bindPopup("<h1><b>RASHT</b></h1><br><h3>IRAN2</h3><br><h3><a href = 'lookup.php?id=2'>info lookup</a></h3>")
        .openPopup();
    L.marker([36.683, 48.483], {
            icon: markers_icon
        }).addTo(map)
        .bindPopup("<h1><b>ZANJAN</b></h1><br><h3>IRAN2</h3><br><h3><a href = 'lookup.php?id=3'>info lookup</a></h3>")
        .openPopup();
    L.marker([35.4, 51.15, ], {
            icon: markers_icon
        }).addTo(map)
        .bindPopup(
            "<h1><b>IMAM KHOMENI</b></h1><br><h3>IRAN2</h3><br><h3><a href = 'lookup.php?id=4'>info lookup</a></h3>")
        .openPopup();
    L.marker([36.25, 50], {
            icon: markers_icon
        }).addTo(map)
        .bindPopup("<h1><b>GHAZVIN</b></h1><br><h3>IRAN</h3><br><h3><a href = 'lookup.php?id=5'>info lookup</a></h3>")
        .openPopup();
    L.marker([36.9, 50.667], {
            icon: markers_icon
        }).addTo(map)
        .bindPopup("<h1><b>RAMSAR</b></h1><br><h3>IRAN2</h3><br><h3><a href = 'lookup.php?id=6'>info lookup</a></h3>")
        .openPopup();
    L.marker([35.4, 51.15, 101], {
            icon: markers_icon
        }).addTo(map)
        .bindPopup("<h1><b>NOSHAHR</b></h1><br><h3>IRAN2</h3><br><h3><a href = 'lookup.php?id=7'>info lookup</a></h3>")
        .openPopup();
    L.marker([36.717, 52.65], {
            icon: markers_icon
        }).addTo(map)
        .bindPopup("<h1><b>BABULSAR</b></h1><br><h3>IRAN2</h3><br><h3><a href = 'lookup.php?id=8'>info lookup</a></h3>")
        .openPopup();
    L.marker([36.417, 54.95], {
            icon: markers_icon
        }).addTo(map)
        .bindPopup("<h1><b>SHAHRUD</b></h1><br><h3>IRAN2</h3><br><h3><a href = 'lookup.php?id=9'>info lookup</a></h3>")
        .openPopup();
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