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
        margin: 0px;
        padding: 0;
        width: 100%;
        height: 100%;
    }
    </style>
</head>

<body>
<?php
    require "$ROOTPATH/pages/navigation.php";

    $query = "";

    if (isset($_POST['newPass'])) {
        $newPass = cleanUserInput($_POST['newPass']);
    }

    if (isset($_POST['newPassCheck'])) {
        $newPassCheck = cleanUserInput($_POST['newPassCheck']);
    }

    if (isset($_POST['oldPass'])) {
        $oldPass = cleanUserInput($_POST['oldPass']);
        $query1 = "SELECT `password` FROM `user` WHERE `id`='$LoggedinID'";
        $result_set1 = mysqli_query($dbConnection, $query1);
        $oldPassWas = mysqli_fetch_assoc($result_set1)['password'];
        if ($oldPass != $oldPassWas) {
            echo "Old password was not correct.";
            $oldPassWas = "";
        }
    }

    if (isset($oldPass) && isset($newPass) && isset($newPassCheck)) {
        if ($newPass == $oldPass) {
            echo "New password cannot be the same as the old password.";
        } else if ($newPass != $newPassCheck) {
            echo "Passwords do not match, please try again.";
        } else if ($newPass == $newPassCheck) {
            $query = "UPDATE `user` SET `password`= '$newPass' WHERE `id`='$LoggedinID'";
            $result_set = mysqli_query($dbConnection, $query);
            $query = "";
            echo "Password updated!";
        }
    }

    if ($Loggedin == false) {
        header("location: index.php");
    } else if ($Loggedin == true) {
        
?>

<div>
<form method="post" action="change_password.php">
    <p1>Old password:</p1><br>
    <input type="password" name="oldPass" placeholder="Old password" required> <br><br>
    <p1>New password:</p1><br>
    <input type="password" name="newPass" placeholder="New password" required> <br><br>
    <p1>Confirm new password:</p1><br>
    <input type="password" name="newPassCheck" placeholder="Confirm new password" required> <br><br>
    <input type="submit" value="Confirm password change">
</form>
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