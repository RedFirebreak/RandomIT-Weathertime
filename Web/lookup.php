<!DOCTYPE html>
<html lang="nl">

<head>

    <?php require "./pages/header.php" ?>

    <title>RandomIT - Lookup</title>
</head>

<body>

    <?php
    // if the user is logged in, send him to the dashboard!
    require "$ROOTPATH/pages/navigation.php";

    if (isset($_GET['id'])) {
        echo " ID = " . $_GET['id'];
    } else {
        echo "NO ID SET";
    }
    ?>
</body>

<footer>
    <?php
        require "./pages/footer.php";
    ?>

</footer>

</html>