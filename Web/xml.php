<?php
require "./pages/header.php";

$days = 1;
$date = retrieveData($_GET['id'], $days, 'Date');
$time = retrieveData($_GET['id'], $days, 'Time');
$temperature = retrieveData($_GET['id'], $days, 'Temperature');
$dewPoint = retrieveData($_GET['id'], $days, 'DewPoint');
$stationLevelPressure = retrieveData($_GET['id'], $days, 'StationLevelPressure');
$seaLevelPressure = retrieveData($_GET['id'], $days, 'SeaLevelPressure');
$visibility = retrieveData($_GET['id'], $days, 'Visibility');
$windSpeed = retrieveData($_GET['id'], $days, 'WindSpeed');
$percipitation = retrieveData($_GET['id'], $days, 'Percipitation');
$snowDrop = retrieveData($_GET['id'], $days, 'SnowDrop');
$freeze = retrieveData($_GET['id'], $days, 'Freeze');
$rain = retrieveData($_GET['id'], $days, 'Rain');
$snow = retrieveData($_GET['id'], $days, 'Snow');
$hail = retrieveData($_GET['id'], $days, 'Hail');
$storm = retrieveData($_GET['id'], $days, 'Storm');
$tornado = retrieveData($_GET['id'], $days, 'Tornado');
$cloudCoverage = retrieveData($_GET['id'], $days, 'CloudCoverage');
$windDirection = retrieveData($_GET['id'], $days, 'WindDirection');

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

$doc = new DOMDocument();
$doc->loadXML($xml);
echo $doc->saveXml();

//Download XML
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename=' . $stationID .'.xml');
?>