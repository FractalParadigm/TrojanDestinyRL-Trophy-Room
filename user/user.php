<?php 
session_start();

include("../admin/db_config.php"); // Include database stuff

try {  // Try opening the SQL database connection
  $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Check if the user exists
  $sqlGetUserList = $conn->prepare("SELECT username FROM " . $userTableName . " WHERE username=\"" . $_GET["username"] . "\"");


  // Execute SQL query
  $sqlGetUserList->execute();

  // Get results from the USERS table
  $results = $sqlGetUserList->fetch();

  $userExists = false;
  // Check if user exists
  if (isset($results)) {
    if (mb_strtolower($_GET["username"]) == mb_strtolower($results["username"])) {
        $userExists = true;
    }
  }


} catch (PDOException $e) { // failed connection
  echo "Connection failed: " . $e->getMessage();
}

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="/styles/primary.css" />
        <link rel="stylesheet" href="/styles/user_management.css" />
        <script src="/scripts/tools.js"></script>
        <script>
            // When the device is rotated, automatically refresh the frame
            screen.orientation.addEventListener("change", (event) => {
                document.getElementById("dataFrame").contentWindow.location.reload();
            });
        </script>
        <title>My Account - Trojan's Trophy Room</title>
    </head>

    <body id="body">
    <script>getURL();</script>
        <div id="contentFrame">
            <img src="/assets/rl_logo_background.svg" alt="Rocket League logo for background" class="backgroundImage">
            <?php include_once('../display/header.html'); ?>
            <?php
            if ($userExists) {
                echo ("<iframe src=\"/user/account.php?username=" . $_GET["username"] . "\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);\"></iframe>");
            } else {
                echo "<div class=\"noUser\">";
                echo "<h2>USER NOT FOUND!</h2>";
                echo "<p>This person may have played some games with us, but hasn't registered an account yet.</p>";
                echo "<p>Please check back later!</p>";
                echo "<p>&nbsp;</p>";
                echo "</div>";
            }
            ?>  
            <?php include_once('../display/subnav.php'); ?>
        </div>
    </body>
</html>