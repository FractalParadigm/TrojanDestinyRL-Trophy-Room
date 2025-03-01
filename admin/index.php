<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="../styles/admin.css" />
        <link rel="stylesheet" href="../styles/admin_nav.css" />
        <script src="../scripts/trojan.js"></script>
        <title>ADMIN PANEL - Trojan's Trophy Room</title>
    </head>

    <body id="body">
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

            $count = 1;

            // EVENTUALLY WE NEED TO MAKE SURE THE PERSON LOGGED IN IS AN ADMIN


            if ($count == 0) { // If no safe admins are found, we'll force creation of one
                echo "<iframe src=\"user_management/create_safe_admin.php\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);\"></iframe>";
            } else { // Otherwise we'll show the nav page
                echo "<iframe src=\"admin_nav.php\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);\"></iframe>";
            }

            ?>

            
            <div id="subNav">
                <a href="./" class="navLink" id="adminHomeButton">ADMIN HOME</a>
                <a href="../" class="navLink" id="mainHomeButton">MAIN HOME</a>
            </div>
        </div>
    </body>
</html>