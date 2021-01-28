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

// Connect to the database
$dbConnection = databaseConnect();

// Start (or resume) a session for the current user
session_start();


// Logout from anywhere
if (isset($_GET['logout'])) {
    session_destroy();
}

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
}

// Define logged in variables
$SESSIONSTATUS = session_status();

// Initialise the session so user variables can be used site-wide
if ($_SESSION['loggedin'] == true && $SESSIONSTATUS == 2) {
    $Loggedin = $_SESSION['loggedin'];
    $LoggedinID = $_SESSION['id'];
    $LoggedinUsername = $_SESSION['name'];
} else {
    // User is not logged in
    $Loggedin = "";
    $LoggedinID = "";
    $LoggedinUsername = "";
}

?>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<link rel="shortcut icon" href="<?php echo $config['logopath'] ?>" type="image/x-icon" />

<!-- Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

<!-- Default stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php echo $SITE; ?>src/css/stylesheet.css">

<!-- CookieBanner -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.css">

<!-- Jquery -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>