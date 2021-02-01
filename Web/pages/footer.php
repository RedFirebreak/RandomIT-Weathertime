<!-- bootstrap -->
<script src="<?php echo $SITE; ?>src/js/bootstrap.js"></script>

<?php
    if ($config['mysql']['hostname'] = "") {
        databaseDisconnect($dbConnection); // disconnect from database
    }
?>