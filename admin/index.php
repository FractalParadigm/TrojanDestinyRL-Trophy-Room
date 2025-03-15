<?php 
session_start();
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="/styles/primary.css" />
        <link rel="stylesheet" href="/styles/admin.css" />
        <script src="/scripts/tools.js"></script>
        <script>
            // When the device is rotated, automatically refresh the frame
            screen.orientation.addEventListener("change", (event) => {
                document.getElementById("dataFrame").contentWindow.location.reload();
            });
        </script>
        <title>ADMIN PANEL - Trojan's Trophy Room</title>
    </head>

    <body id="body">
    <script>getURL();</script>
        <div id="contentFrame">
            <img src="/assets/rl_logo_background.svg" alt="Rocket League logo for background" class="backgroundImage">
            <?php include_once('../display/header.html'); ?>
            <h2 id="adminHeader">ADMIN PANEL</h2>

            <?php
            /*   This little bit of code is going to check whether or not we have
               at least one "safe admin" user - this is someone who isn't gonna be 
               deleted by the (re)initialization script, a 'master administrator' 
               for the program if you like.
            */

            include ("db_config.php");
            
            try {  // Try opening the SQL database connection
                $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Check if the admin table exists
                $sqlCheckAdminTable = $conn->prepare("SHOW TABLES LIKE '" . $adminUserTableName . "'");
                
                // Run the query
                $sqlCheckAdminTable->execute();
          
            } catch (PDOException $e) { // failed connection
                echo "SQL connection failed: " . $e->getMessage();
            }

            //Check if any rows exist
            $count = $sqlCheckAdminTable->rowCount();

            
            /* This if-statement controls the display of the admin page
            //  First we check if there's actually gonna be an admin user
            //   - we do this by checking the safe-admin database, because
            //     if there's at least one user there, they would have been
            //     copied into the primary user database upon initialization
            //
            //  Then we check if the person is logged in or not - if not,
            //    we re-direct them to the login page, where we'll be 
            //    brought back after logging in
            //
            //  We are also checking if the person is an admin user -
            //    if they are NOT, then we show the 'not_admin' page, 
            //    telling the user they're not allowed to view the content
            */

            if ($count == 0) { // If no safe admins are found, we'll force creation of one
                echo "<iframe src=\"user_management/create_safe_admin.php\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);\"></iframe>";
            } else { // Otherwise we'll show the nav page
                if (!isset($_SESSION["userID"])){
                    echo "<iframe src=\"../user/login_page.php?redirect=admin\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);\"></iframe>";
                } else if (isset($_SESSION["userID"]) && $_SESSION["privileges"] == 1) {
                    echo "<iframe src=\"admin_nav.html\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);\"></iframe>";
                } else {
                    echo "<iframe src=\"not_admin.html\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);\"></iframe>";
                }
            }
            ?>

            
            <?php include_once('../display/subnav.php'); ?>
        </div>
    </body>
</html>