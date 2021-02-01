<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "./pages/header.php" ?>

    <title>RandomIT - Lookup</title>
    <style>
    table,
    th {
        text-align: center;
        padding-right: 10px;
        padding-left: 10px;
        border: 1px solid black;
    }

    td,
    tr {
        text-align: left;
        padding-right: 10px;
        padding-left: 1%;
        border: 1px solid black;
    }

    h3 {
        color: black;
    }
    </style>
</head>

<body>
    <?php
    //If the user is logged in, send him to the dashboard!
    require "$ROOTPATH/pages/navigation.php";

    if (isset($_GET['id'])) {
        $id = cleanUserInput($_GET['id']);

        $conn = databaseConnect();

        if ($conn->connect_error) {
            die("Database connection failed! " . $conn->connect_error);
        }
        $sql = "SELECT name, country FROM stations WHERE stn = '$id'";
        $result = $conn->query($sql);

        $tempResult = [];
        if ($result->num_rows > 0) {
            //Output data of each row
            while ($row = $result->fetch_assoc()) {
                array_push($tempResult, $row["name"], $row["country"]);
            }
        }
    } else {
        echo "NO ID SET";
    }
    
    //Redirect the user if they have not been logged in
    if (!$Loggedin) {
        header("location: index.php");
    } else if ($Loggedin) {

    $tableHeaders = ["Storm", "Temperature", "Air Pressure", "Snow", "Windspeed", "Cloud Coverage", "Dew Point", "Rain",
        "Precipitation", "Snow Drop", "SeaLevelPressure", "Visibility", "Tornado", "WindDirection", "Freeze", "Hail"];

    $dataTypes = ["", "°C", "mbar", "", "km/h", "%", "", "°C", "", "", "", "cm", "cm", "", "mbar", "km", "", "°", "", "", ""];

    $JSONfiles = retrieveJsonsPerStation($id, 7 );

    echo '<div class="container h-100" style="min-width: 86%">
            <div class="row h-100 align-items-center">
                <div class="col-12 whiteborder text-center">';
                echo "<h3 style='color:#ff00aa'>" . $id . " " . $tempResult[0] . ", " . $tempResult[1] . "</h3>";
                echo "<a href='xml.php?id=". $id ."&days=7' class='btn btn-danger' target='_blank'>Download XML</a>";
                    echo "<div class='table-responsive'>";

    echo "<table class='table'>
    <thead>
    <th scope='col'> Date </th>";

    for ($i=0; $i < sizeof($tableHeaders); $i++) {
        echo "<th scope='col'>" . $tableHeaders[$i] . "</th>";
    }
    echo "</thead>
    <tbody>";

    //Loop through all JSON files and add them as table lines
    foreach($JSONfiles as $file) {
        echo "<tr>
        <td style='text-align: center'>{$file['Date']}<br>{$file['Time']}</td>";

        $i = 0;
        foreach($file as $line) {
            if(!($line == $file['Time'] || $line == $file['Client'] or $line == $file['StationNumber'] || $line == $file['Timestamp'] || $line == $file['Date'])) {

                if ($line == 'false') { 
                    $line = 'No';
                } elseif ($line == 'true') { 
                    $line = 'Yes'; 
                } elseif ($line == "MISSING") {
                    $line = extrapolate($file['StationNumber'], 7, key($file));
                    echo "<td>" . $line . "{$dataTypes[$i]} </td>";
                } else {
                    echo "<td>" . $line . "{$dataTypes[$i]} </td>";
                }
            }
            $i++;
            next($file);
        }
        echo "</tr>
        </tbody>";

    }
    echo '</table>
                </div>
            </div>
            </div>
        </div>';
    }
?>
</body>

<footer>
    <?php
        require "./pages/footer.php";
    ?>

</footer>
</html>