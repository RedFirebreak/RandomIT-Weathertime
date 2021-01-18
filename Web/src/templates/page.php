<!DOCTYPE html>
<html lang="nl">

<head>
    <?php
        // point the header to the right location. Only variable paths by doin ../ to go a folder back
        require "../pages/header.php";
        //Customlog ("homepage", "error", "errorboi");
    ?>
    <!-- (optional) load extra stylesheets, default is loaded in the header
    <link rel="stylesheet" type="text/css" href="<?php GetRootPath(); ?>/src/css/login.css"> -->

    <title>RandomIT - Now with wacky titles!</title>
</head>

<body>
    <?php
        require "$ROOTPATH/pages/navigation.php";
    ?>

    <!-- place content here -->




</body>

<footer>
    <?php
        // We load a ROOTPATH in the header, so now we can access all the files from everywhere
        require "$ROOTPATH/pages/footer.php";
    ?>
</footer>

</html>