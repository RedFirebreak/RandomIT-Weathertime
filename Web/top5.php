<!DOCTYPE html>
<html lang="nl">

<head>

    <?php require "./pages/header.php" ?>

    <title>RandomIT - Lookup</title>
    <style>
        table, th {
            text-align: center;
            padding-right: 10px;
            padding-left: 10px;
            border: 1px solid black;
        }
        td, tr {
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
// if the user is logged in, send him to the dashboard!
require "$ROOTPATH/pages/navigation.php";

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
} else {
    echo "NO ID SET";
}

//Redirect the user if they have not been logged in
if (!$Loggedin) {
    header("location: index.php");
} else if ($Loggedin) {

    $DIR = '../weatherdata/';
    $jsonArray = [];
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

    foreach($relevantStations as $id) {
        if (!empty(retrieveJSONsPerStation($id, 7))) {
            array_push($jsonArray,retrieveJSONsPerStation($id, 7));
        }
    }




    echo '<div class="container h-100" style="min-width: 86%">
                <div class="row h-100 align-items-center">
                    <div class="col-12 whiteborder text-center">';
    echo "<div class='table-responsive'>";

    echo "<table class='table'>
        <thead>";

    $slicesArray = [];

    foreach($jsonArray as $station) {
        $temperatures = array_column($station, 'Temperature');
        array_multisort($station, SORT_DESC, $temperatures);
        foreach($station as $data) {
            $slice = array_slice($station, 0, 5);
            array_push($slicesArray);
        }

    }
    $top5 = [];
    foreach($slicesArray as $station) {
        $temperatures = array_column($station, 'Temperature');
        array_multisort($station, SORT_DESC, $temperatures);
        foreach($station as $data) {
            $slice = array_slice($station, 0, 5);
            array_push($top5, $slice);
        }
    }
    foreach($top5 as $station) {
        print_r($station);
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