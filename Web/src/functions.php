<?php
// Refresh $rootpath
$ROOTPATH = GetRootPath();

// Always and I mean ALWAYS use this function while dealing with user input to make sure it gets stored savely in the database.
function cleanUserInput($userinput) {
    $dbConnection = databaseConnect();
    if (empty($userinput)) {
        return;
    } else {
        $userinput = htmlspecialchars($userinput);
        $userinput = mysqli_real_escape_string($dbConnection, $userinput);
    }
    databaseDisconnect($dbConnection); // disconnect from database
    return $userinput;
}


// Decode *potentially HARMFULL* data from the database
function decodeUserInput($userinput) {
    $userinput = htmlspecialchars_decode($userinput);
    return $userinput;
}

function databaseConnect() {
    global $config;

    // Only open database connection if we actually have one
    if ($config['mysql']['hostname'] = "") {
        //connect to database
        $db_conn = mysqli_connect(
            $config['mysql']['hostname'],
            $config['mysql']['username'],
            $config['mysql']['password'],
            $config['mysql']['database'],
            $config['mysql']['port']
        );

        // check connection
        if (mysqli_connect_errno()) {
            //Throw error (Cant save in database, cuz no connection.)
            $errordate = date("j-n-Y");
            $errortime = date("h:i:s");
            $docname = basename(__FILE__);
            $errormessage = "$errortime | $docname | FAILED DATABASE CONNECTION: " . mysqli_connect_error() . "\n";

            // Write in the main logging file
            $dbconnectionerrorfile = fopen("src/logs/{$errordate}_AllLogs.log", "a");
            fwrite($dbconnectionerrorfile, $errormessage);
            fclose($dbconnectionerrorfile);

            // Write seperate file
            $dbconnectionerrorfile = fopen("src/logs/filtered/{$errordate}_db-fail.log", "a");
            fwrite($dbconnectionerrorfile, $errormessage);
            fclose($dbconnectionerrorfile);

            // Inform the user of the error
            echo "<h1>The database connection has failed.<br>";
            echo "<p>The admins have been notified of this error. Please come back later!</p>";
            echo "<br>";
            exit();
        }
        //echo "connected";
        return $db_conn;
    } else {
        echo "LOG: Config had no mysql info, skipping database connection";
    }
}

function databaseDisconnect($db_conn) {
        mysqli_close($db_conn);
}

function datesFormatting($databasedate) {
    // To be sure, clean the date
    $inputdate = cleanUserInput($databasedate);

    // StroToTime mafs
    $strtotimeinput = strtotime("$inputdate"); //Future date.
    $timeNow = strtotime("now");

    $timeleft = $timeNow - $strtotimeinput; // Future will result in a negative value.

    $leftdays = (int)abs(($timeleft / 24 / 60 / 60)); // Get the amount of days, then cut off numbers after the decimal by casting to int
    $hoursleft = (int)abs((($timeleft / 60 / 60) % 24)); // timeleft in hours, minus every 24 hours
    $minutesleft = (int)abs((($timeleft / 60)) % 60); // Time in minutes, minus every 60 minutes
    $secondsleft = (int)abs($timeleft % 60); // Time in seconds, minus every 60 seconds

    // Formatting for messages
    if ($leftdays != 1) {
        $textdagen = "dagen";
    } else {
        $textdagen = "dag";
    }

    if ($hoursleft != 1) {
        $texturen = "uren";
    } else {
        $texturen = "uur";
    }

    if ($minutesleft != 1) {
        $textminuten = "minuten";
    } else {
        $textminuten = "minuut";
    }

    if ($secondsleft != 1) {
        $textseconden = "seconden";
    } else {
        $textseconden = "seconde";
    }

    if ($timeleft >= 0) { // A negative value means in the future
        $future = false;
    } else {
        $future = true;
    }

    // Format output
    $output = date('d-m-Y H:i:s', $strtotimeinput);
    $outputnow = date('d-m-Y H:i:s', $timeNow);

    // Message
    if ($future) {
        $fullmessage = "Over $leftdays $textdagen, $hoursleft $texturen, $minutesleft $textminuten, $secondsleft $textseconden ";
        $usefullmessage = "Over $leftdays $textdagen, $hoursleft $texturen, $minutesleft $textminuten";
        $daysmessage = "Over $leftdays $textdagen";
    } else {
        $fullmessage = "$leftdays $textdagen, $hoursleft $texturen, $minutesleft $textminuten, $secondsleft $textseconden geleden";
        $usefullmessage = "$leftdays $textdagen, $hoursleft $texturen, $minutesleft $textminuten geleden";
        $daysmessage = "$leftdays $textdagen geleden";
    }

    // Make the array
    $returnarray = array(
        'input' => $inputdate,
        'output' => $output,
        'strtotimeinput' => $strtotimeinput,
        'strtotimenow' => $timeNow,
        'strtotimeleft' => $timeleft,
        'now' => $outputnow,
        'future' => $future,
        'daysfromnow' => $leftdays,
        'hoursfromnow' => $hoursleft,
        'minutesfromnow' => $minutesleft,
        'secondsfromdagen' => $secondsleft,
        'textdagen' => $textdagen,
        'texturen' => $texturen,
        'textminuten' => $textminuten,
        'textseconden' => $textseconden,
        'fullmessage' => $fullmessage,
        'usefullmessage' => $usefullmessage,
        'daysmessage' => $daysmessage,
    );
    return $returnarray;
}


function randomNumber($length) {
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }
    return $result;
}

function toString($array) {
    $string = implode(" ", $array);
    return "$string";
}

?>