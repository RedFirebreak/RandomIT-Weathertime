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
        padding-top: 0px !important;
        margin: 0px;
        padding: 0;
        width: 100%;
        height: 100%;
    }
    </style>

    <title>Randomit - Password change</title>
    <link rel="stylesheet" type="text/css" href="<?php GetRootPath(); ?>/src/css/login.css">

</head>

<body>
    <?php
    require "$ROOTPATH/pages/navigation.php";

    // Parse the password change if POST is set
    if (isset($_POST['newPass'])) {
        $query = "";
        $fails = 0;

        if (isset($_POST['newPass'])) {
            $newPass = cleanUserInput($_POST['newPass']);
        } else {
            $usermessagecolor   = "danger"; // success or danger
            $usermessage        = "Your forgot to enter the new password!";
            $fails++;
        }
    
        if (isset($_POST['newPassCheck']) && $fails == 0) {
            $newPassCheck = cleanUserInput($_POST['newPassCheck']);
        } else {
            $usermessagecolor   = "danger"; // success or danger
            $usermessage        = "Your forgot to enter the second new password!";
            $fails++;
        }

        if (isset($_POST['oldPass']) && $fails == 0) {
            $oldPass = cleanUserInput($_POST['oldPass']);
            $query1 = "SELECT `password` FROM `user` WHERE `id`='$LoggedinID'";
            $result_set1 = mysqli_query($dbConnection, $query1);
            $oldPassWas = mysqli_fetch_assoc($result_set1)['password'];
            if ($oldPass != $oldPassWas) {
                $usermessagecolor   = "danger"; // success or danger
                $usermessage        = "Old password was not correct.";
                $oldPassWas = "";
                $fails++;
            }
        }

        if (isset($oldPass) && isset($newPass) && isset($newPassCheck) && $fails == 0) {
            if ($newPass == $oldPass) {
                $usermessagecolor   = "danger"; // success or danger
                $usermessage        = "New password cannot be the same as the old password.";
            } else if ($newPass != $newPassCheck) {
                $usermessagecolor   = "danger"; // success or danger
                $usermessage        = "Passwords do not match, please try again.";
            } else if ($newPass == $newPassCheck) {
                $query = "UPDATE `user` SET `password`= '$newPass' WHERE `id`='$LoggedinID'";
                $result_set = mysqli_query($dbConnection, $query);
                $query = "";
                $usermessagecolor   = "success"; // success or danger
                $usermessage        = "Your password has been sucesfully updated!";
            }
        }
    }

    // Redirect the user if they have not been logged in
    if ($Loggedin == false) {
        header("location: index.php");
    } else if ($Loggedin == true) {

    // Show the form / message
?>
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
                                <h2 class="login-heading mb-4 text-center text-blue">Change your password here</h2>

                                <?php // Now load the login functionality
                                if (isset($usermessage)) {
                                    echo "<div class='alert alert-$usermessagecolor' role='alert'>";
                                    echo "$usermessage";
                                    echo "</div>";
                                }
                            ?>

                                <form id="loginform" action="" method="POST">

                                    <div class="form-label-group">
                                        <input type="password" id="oldPass" name="oldPass" class="form-control"
                                            placeholder="Password" required>
                                        <label for="oldPass">Old password</label>
                                    </div>

                                    <div class="form-label-group">
                                        <input type="password" id="newPass" name="newPass" class="form-control"
                                            placeholder="Password" required>
                                        <label for="newPass">New password</label>
                                    </div>

                                    <div class="form-label-group">
                                        <input type="password" id="newPassCheck" name="newPassCheck"
                                            class="form-control" placeholder="Password" required>
                                        <label for="newPassCheck">New password (again)</label>
                                    </div>

                                    <button
                                        class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2"
                                        id="loginsubmitbutton" type="submit">Confirm password change
                                    </button>

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    }
?>

</body>

<footer>
    <?php
        require "./pages/footer.php";
    ?>
</footer>

</html>