<?php
function GetRootPath() {
    global $config; //Open config
    $return = dirname(__FILE__);
    $return = str_replace ( "\pages" , "" , $return);
    $return = str_replace ( "/pages" , "" , $return); //Linux compatibility
    return $return;
}

//Define rootpath
$ROOTPATH = GetRootPath();

//Redirect the user if they have not been logged in
if (!$Loggedin) {
    header("location: index.php");
} else if ($Loggedin) {

    //Load config file or display the instructions
    if (file_exists("$ROOTPATH/src/config.php")) {
        require "$ROOTPATH/src/config.php";
    } else {
        echo "<h1>The config file is not present or is not readable!</h1> Please make sure to recreate your own config file in the /src/ folder.
        <br><br>Please copy <b>/src/config.php.example</b> to <b>/src/config.php</b> and fill out the required info inside of the config file.<br>Still can't figure it out? Send RedFirebreak a message.";
        exit;
    }

    //Define SITE
    $SITE = $config['sitepath'];

    //Load all functions
    require "$ROOTPATH/src/functions.php";

    //Define DIR for json files
    $DIR = "./UniversityTeheran/";

    $DIR = $config['jsondir'];

$days = cleanUserInput($_GET['days']);
$ID = cleanUserInput($_GET['id']);

    $days = 1;
    $ID = cleanUserInput($_GET['id']);

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