<?php 
require "./pages/header.php";
// parse any POST requests here

if (isset($_POST['login'])) {

    $username   = cleanUserInput($_POST['login']);
    $password   = cleanUserInput($_POST['password']);
    $fails      = 0;

    if (empty($username) && $fails == 0) {
        $loggedincolor = "danger"; // success or danger
        $loggedinmessage = "You need to fill in a username";
        $fails++;
      }
    if (empty($password) && $fails == 0) {
        $loggedincolor = "danger"; // success or danger
        $loggedinmessage = "You need to fill in a password";
        $fails++;
    }


    // yes this is insecure, password encryption will be done later!
    if ($fails == 0) {
        // Query the database with this info
        $query = "SELECT `id`, `username` FROM user WHERE `username`='$username' && `password`='$password'";
        $results = mysqli_query($dbConnection, $query);

        if (mysqli_num_rows($results) == 1) {
            $row = mysqli_fetch_assoc($results);
            $validlogin = True;

            // Set the info into the session
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['username'];

            // Set the global variables
            $Loggedin = $_SESSION['loggedin'];
            $LoggedinID = $_SESSION['id'];
            $LoggedinUsername = $_SESSION['name'];

            $loggedincolor = "success"; // success or danger
            $loggedinmessage = "You are now logged in and will be redirected!"; 

            header("Refresh:1; url=../");

        } else {
            $loggedincolor = "danger"; // success or danger
            $loggedinmessage = "The information you entered is invalid"; 
        }
    }
} else {

}


?>

<head>

    <title>Randomit - Login page</title>
    <link rel="stylesheet" type="text/css" href="<?php GetRootPath(); ?>/src/css/login.css">

    <style>
    body {
        padding-top: 0px !important;
    }
    </style>
</head>

<div class="container-fluid">
    <div class="row no-gutter">
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image">
            <!-- This is the background image of the page, done with CSS -->
        </div>
        <div class="col-md-8 col-lg-6">
            <div class="login d-flex align-items-center py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-lg-8 mx-auto loginframe">
                            <h2 class="login-heading mb-4 text-center text-blue">Welcome back!</h2>

                            <?php // Now load the login functionality
                                if (isset($loggedinmessage)) {
                                    echo "<div class='alert alert-$loggedincolor' role='alert'>";
                                    echo "$loggedinmessage";
                                    echo "</div>";
                                }
                            ?>

                            <form id="loginform" action="" method="POST">
                                <div class="form-label-group">
                                    <input type="text" id="inputEmail" name="login" class="form-control"
                                        placeholder="Email address" required autofocus>
                                    <label for="inputEmail">Username</label>
                                </div>
                                <div class="form-label-group">
                                    <input type="password" id="inputPassword" name="password" class="form-control"
                                        placeholder="Password" required>
                                    <label for="inputPassword">Password</label>
                                </div>

                                <!--
                                <div class="custom-control custom-checkbox mb-3">
                                    <input name="rememberme" type="checkbox" class="custom-control-input"
                                        id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Remember me!</label>
                                </div>
                                -->

                                <button
                                    class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2"
                                    id="loginsubmitbutton" type="submit">Log in
                                </button>

                                <!--
                                <div class="text-center">
                                    <a class="small" href="resetpassword.php">Forgot password?</a>
                                    <br><br>
                                </div>
                                -->
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>