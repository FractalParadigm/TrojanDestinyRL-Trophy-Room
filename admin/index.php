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
        <title>ADMIN PANEL - Trojan's Trophy Room</title>
    </head>

    <body id="body">
    <script>getURL();</script>
        <div id="contentFrame">
            <h1>Trojan's Trophy Room</h1>
            <h2 id="adminHeader">ADMIN PANEL</h2>

            <?php
            /*   This little bit of code is going to check whether or not we have
               at least one "safe admin" user - this is someone who isn't gonna be 
               deleted by the (re)initialization script, a 'master administrator' 
               for the program if you like.
            */

            include ("db_config.php");
            
            try {  // Try opening the SQL database connection
                $conn = new PDO("mysql:host=$servername; dbname=$dbName", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) { // failed connection
                echo "SQL connection failed: " . $e->getMessage();
            }

            // Check if the admin table exists
            $sqlCheckAdminTable = $conn->prepare("SHOW TABLES LIKE '" . $adminUserTableName . "'");
          
            // Run the query
            $sqlCheckAdminTable->execute();
          
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
                    echo "<iframe src=\"../login_page.php?redirect=admin\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);\"></iframe>";
                } else if (isset($_SESSION["userID"]) && $_SESSION["isAdmin"] == 1) {
                    echo "<iframe src=\"admin_nav.php\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);\"></iframe>";
                } else {
                    echo "<iframe src=\"not_admin.php\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);\"></iframe>";
                }
            }
            ?>

            
            <div class="subNav">
                <?php
                if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == 1) {
                    echo "<a href=\"./\" class=\"subNavLink\" id=\"adminHomeButton\">ADMIN HOME</a>";
                }
                ?>
                <a href="../" class="subNavLink" id="mainHomeButton">MAIN HOME</a>
                <p class="newLine"></p>
                <?php 
                if (isset($_SESSION["userID"])){
                    echo "<a href=\"../logout.php?redirect=admin\" class=\"subNavLink\" id=\"loginButton\">LOGOUT</a>";
                }
                ?>
            </div>
        </div>
    </body>
</html>