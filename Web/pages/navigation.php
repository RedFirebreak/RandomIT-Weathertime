<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $config['sitepath'] ?>"><img src="<?php echo $config['logopath'] ?>"
                class="img-fluid navbarlogo" alt="Logo"><?php echo $config['sitetile']?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo $config['sitepath'] ?>">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <?php if ($Loggedin) { ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="account" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="./src/img/defaultaccountimage.png" width="30" height="30"
                            class="rounded-circle d-inline-block align-top" alt="">
                        Welcome <?php echo $LoggedinUsername ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="account">

                        <a style="color: black;" class="dropdown-item" href="change_password.php">
                            Change password
                        </a>

                        <a style="color: red;" class="dropdown-item" href="?logout=1">
                            log-out
                        </a>

                    </div>
                </li>


                <?php } else { ?>

                <li class="nav-item">
                    <a class="nav-link" href="login.php">Log-in</a>
                </li>

                <?php } ?>
            </ul>
        </div>
    </div>
</nav>