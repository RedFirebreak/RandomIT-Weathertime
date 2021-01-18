<!DOCTYPE html>
<html lang="nl">

<head>

    <?php require "./pages/header.php" ?>

    <title>RandomIT - Homepage</title>
</head>

<body>
    <?php
    // if the user is logged in, send him to the dashboard!
    require "$ROOTPATH/pages/navigation.php";
    ?>

    <!-- Full Page Image Header with Vertically Centered Content -->
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center">
                    <h1 class="font-weight-light whitetext"><b><?php echo $config['sitetile']?></b></h1>
                    <p class="lead"><?php echo $config['siteslogan'] ?></p>
                    <br>

                    <div class="homeloginbutton">
                        <a href="<?php GetRootPath(); ?>" class="border border-dark btn btn-primary">Log-in</a>
                    </div>

                    <br>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <div class="container">
        <div class="col-md-12 whiteborder ">
            <h2 class="text-blue text-center">Over <?php echo $config['sitetile']?></h2>
            <p>This is a project by or fiction-based company called "Random-IT". The gist of this project is to think
                of, make and present a real-world project/problem and present these to 'actual' clients as a solution
                for their IT infrastructure.

                <span class="text-left">
                    <br><b>The following project includes:</b>

                    <li>- An interactive front-end for clients</li>
                    <li>- A admin portal (backend OR protected front-end)</li>
                    <li>- A data collector / scraper</li>
                    <li>- Some means of storing and filtering usefull data</li>
                </span>
                <br>
                We, "Random-It", are hyped to get started and are very eager to deliver an actual project for a fake
                company.
            </p>
        </div>
    </div>

</body>

<footer>
    <?php
        require "./pages/footer.php";
    ?>

</footer>

</html>