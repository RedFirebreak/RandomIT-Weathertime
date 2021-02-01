<!DOCTYPE html>
<html lang="nl">

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
    /**
     * Page that displays the top 5 stations based on peak temperature.
     * @author Jens Maas
     */

// if the user is logged in, send him to the dashboard!
require "$ROOTPATH/pages/navigation.php";

// make db connection
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = databaseConnect();

    if ($conn->connect_error) {
        die("Database connection failed! " . $conn->connect_error);
    }
    $sql = "SELECT name, country FROM stations WHERE stn = '$id'";
    $result = $conn->query($sql);

    $tempResult = [];
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($tempResult, $row["name"], $row["country"]);
        }
    }
}
?>

    <?php


$jsonArray = [];

$tableHeaders = ["Storm", "Temperature", "Air Pressure", "Snow", "Windspeed", "Cloud Coverage", "Dew Point", "Rain",
    "Precipitation", "Snow Drop", "SeaLevelPressure", "Visibility", "Tornado", "WindDirection", "Freeze", "Hail"];

$dataTypes = ["", "°C", "mbar", "", "km/h", "%", "", "°C", "", "", "", "cm", "cm", "", "mbar", "km", "", "°", "", "", ""];

//Stations that are relevant for the client and eligible to make the top 5.

$relevantStations = [375750, 378630, 378635, 378640, 379070, 379850, 381412, 403560, 403570, 403584, 403600, 403610,
    403620, 403720, 403730, 403750, 403770, 403940, 404050, 404150, 404160, 404170, 404200, 404300, 404370, 404380,
    404390, 404450, 404770, 404800, 404950, 404980, 404480, 404490, 404520, 411840, 411940, 411960, 411980, 412160,
    412170, 412180, 412410, 412460, 412540, 412560, 412880, 413140, 413160, 405750, 407060, 407090, 407120, 407180,
    407190, 407290, 407300, 407310, 407320, 407340, 407360, 407390, 407430, 407450, 407470, 407540, 407570, 407620,
    407660, 407720, 407780, 407802, 408000, 408090, 408110, 408190, 408210, 408230, 408310, 408410, 408480, 408560,
    408580, 408590, 408750, 408790, 409480, 415300, 415710, 416410, 417490, 417560, 417800, 170220, 170240, 170260,
    170300, 170310, 170340, 170380, 170420, 170500, 170560, 170575, 170600, 170660, 170670, 170671, 170672, 170673,
    170674, 170700, 170820, 170840, 170860, 170880, 170900, 170920, 170960, 170980, 171100, 171120, 171150, 171160,
    171200, 171240, 171270, 171280, 171290, 171295, 171350, 171400, 171500, 171550, 171600, 171700, 171750, 171800,
    171840, 171880, 171890, 171900, 171905, 171950, 171990, 172000, 172005, 172020, 172050, 172100, 172180, 172190,
    172340, 172370, 172400, 172410, 172440, 172480, 172500, 172600, 172700, 172720, 172734, 172800, 172900, 172920,
    172950, 173000, 173100, 173300, 173500, 173520, 173700, 173750, 691464];


echo '<div class="container h-100" style="min-width: 95%">
            <div class="row h-100 align-items-center">
                <div class="col-12 whiteborder text-center">';
                echo "<h3 style='color:#ff00aa'>Top 5 of weather station (Based on peak temperature)</h3>";
                    echo "<div class='table-responsive'>";

echo "<table class='table'>
    <thead>
    <th scope='col'> Station</th>
    <th scope='col'> Date </th>";

for ($i = 0; $i < sizeof($tableHeaders); $i++) {
    echo "<th scope='col'>" . $tableHeaders[$i] . "</th>";
}
echo "</thead>";

    /**
     * For each relevant station all JSON files are loaded. retrieveJSONsPerStation returns an array,
     * which is sorted based on the temperature values. The top value (and all other station data
     * is then added to the $jsonArray
     */
foreach ($relevantStations as $id) {
    if (!empty(retrieveJSONsPerStation($id, 7))) {
        $tempArray = retrieveJSONsPerStation($id, 7);
        $temperatures = array_column($tempArray, 'Temperature');
        array_multisort($tempArray, SORT_DESC, $temperatures);
        array_push($jsonArray, (array_slice($tempArray, 0, 1)[0]));
    }
}

    /**
     * All peak value data in the $jsonArray is then sorted again based on temperature and the
     * first 5 indices are selected and added to the $top5 array.
     */
$temperatures = array_column($jsonArray, 'Temperature');
array_multisort($jsonArray, SORT_DESC, $temperatures);
$top5 = array_slice($jsonArray, 0, 5);


    /**
     * Connect to database to retrieve weather station name and country based on station number.
     * Then fill the table with the relevant data and their types.
     */

$conn = databaseConnect();
if ($conn->connect_error) {
    die("Database connection failed! " . $conn->connect_error);
}
echo "<tbody>";
foreach ($top5 as $winnaar) {
    $id = $winnaar['StationNumber'];
    $sql = "SELECT name, country FROM stations WHERE stn = '$id'";
    $result = $conn->query($sql);

    $tempResult = [];
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($tempResult, $row["name"], $row["country"]);
        }
    }
    echo "<tr>
        <td style='text-align: center'>{$winnaar['StationNumber']}<br>{$tempResult[0]},<br>{$tempResult[1]}</td>
        <td style='text-align: center'>{$winnaar['Date']}<br>{$winnaar['Time']}</td> 
        ";

    $i = 0;
    foreach ($winnaar as $line) {
        if (!($line == $winnaar['Time'] or $line == $winnaar['Client'] or $line == $winnaar['StationNumber']
            or $line == $winnaar['Timestamp'] or $line == $winnaar['Date'])) {
            if ($line == 'false') $line = 'No';
            if ($line == 'true') $line = 'Yes';
            echo "<td>" . $line . "{$dataTypes[$i]}" . "</td>";
        }
        $i++;
        next($winnaar);
    }
}

echo "</tr>
      </tbody>";
echo '</table>
                </div>
            </div>
            </div>
        </div>';


?>
</body>

<footer>
    <?php
    require "./pages/footer.php";
    ?>

</footer>

</html>