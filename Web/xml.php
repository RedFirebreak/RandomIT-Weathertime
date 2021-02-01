<?php
function GetRootPath() {
    global $config; // open config
    $return = dirname(__FILE__);
    $return = str_replace ( "\pages" , "" , $return);
    $return = str_replace ( "/pages" , "" , $return); // linux compatibility
    return $return; // return
}

// Define rootpath
$ROOTPATH = GetRootPath();

// Load config file or display the instructions
if (file_exists("$ROOTPATH/src/config.php")) {
    require "$ROOTPATH/src/config.php";
} else {
    echo "<h1>The config file is not present or is not readable!</h1> Please make sure to recreate your own config file in the /src/ folder.
    <br><br>Please copy <b>/src/config.php.example</b> to <b>/src/config.php</b> and fill out the required info inside of the config file.<br>Still can't figure it out? Send RedFirebreak a message.";
    exit;
}

// Define SITE
$SITE = $config['sitepath'];

// Load all functions
require "$ROOTPATH/src/functions.php";

// Define DIR for json files
$DIR = "./UniversityTeheran/";

$DIR = $config['jsondir'];

// Connect to the database
$dbConnection = databaseConnect();

$days = cleanUserInput($_GET['days']);
$ID = cleanUserInput($_GET['id']);

$date = retrieveData($ID, $days, 'Date');
$time = retrieveData($ID, $days, 'Time');
$temperature = retrieveData($ID, $days, 'Temperature');
$dewPoint = retrieveData($ID, $days, 'DewPoint');
$stationLevelPressure = retrieveData($ID, $days, 'StationLevelPressure');
$seaLevelPressure = retrieveData($ID, $days, 'SeaLevelPressure');
$visibility = retrieveData($ID, $days, 'Visibility');
$windSpeed = retrieveData($ID, $days, 'Windspeed');
$percipitation = retrieveData($ID, $days, 'Percipitation');
$snowDrop = retrieveData($ID, $days, 'SnowDrop');
$freeze = retrieveData($ID, $days, 'Freeze');
$rain = retrieveData($ID, $days, 'Rain');
$snow = retrieveData($ID, $days, 'Snow');
$hail = retrieveData($ID, $days, 'Hail');
$storm = retrieveData($ID, $days, 'Storm');
$tornado = retrieveData($ID, $days, 'Tornado');
$cloudCoverage = retrieveData($ID, $days, 'CloudCoverage');
$windDirection = retrieveData($ID, $days, 'WindDirection');

// Parse data, format properly
$xml = "<?xml version=\"1.0\"?>\n";
$xml .= "<WEATHERDATA>\n";
    for ($i = count($time) - 1; $i > -1; $i--) {
    $measurement = "\t<MEASUREMENT>\n";
        $measurement .= "\t\t<DATE>" . $date[$i] . "</DATE>\n";
        $measurement .= "\t\t<TIME>" . $time[$i] . "</TIME>\n";
        $measurement .= "\t\t<TEMP>" . $temperature[$i] . "</TEMP>\n";
        $measurement .= "\t\t<DEWP>" . $dewPoint[$i] . "</DEWP>\n";
        $measurement .= "\t\t<PRCP>" . $percipitation[$i] . "</PRCP>\n";
        $measurement .= "\t\t<SNDP>" . $snowDrop[$i] . "</SNDP>\n";
        $measurement .= "\t\t<CLDC>" . $cloudCoverage[$i] . "</CLDC>\n";
        $measurement .= "\t\t<VISIB>" . $visibility[$i] . "</VISIB>\n";
        $measurement .= "\t\t<WDSP>" . $windSpeed[$i] . "</WDSP>\n";
        $measurement .= "\t\t<WNDDIR>" . $windDirection[$i] . "</WNDDIR>\n";
        $measurement .= "\t\t<STP>" . $stationLevelPressure[$i] . "</STP>\n";
        $measurement .= "\t\t<SLP>" . $seaLevelPressure[$i] . "</SLP>\n";
        $measurement .= "\t\t<FREEZE>" . $freeze[$i] . "</FREEZE>\n";
        $measurement .= "\t\t<RAIN>" . $rain[$i] . "</RAIN>\n";
        $measurement .= "\t\t<SNOW>" . $snow[$i] . "</SNOW>\n";
        $measurement .= "\t\t<HAIL>" . $hail[$i] . "</HAIL>\n";
        $measurement .= "\t\t<STORM>" . $storm[$i] . "</STORM>\n";
        $measurement .= "\t\t<TORNADO>" . $tornado[$i] . "</TORNADO>\n";
        $measurement .= "\t</MEASUREMENT>\n";
    $xml .= $measurement;
    }
    $xml .= "</WEATHERDATA>\n";

//Download XML (DOM)
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename=' . $ID .'.xml');

$doc = new DOMDocument("1.0", "utf-8"); // new DOM to save xml
$yes = $doc->loadXML($xml, LIBXML_PARSEHUGE);

echo $xml; // Echoing makes the xml actually "send"

?>