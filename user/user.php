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

  // Check if user exists
  if (mb_strtolower($_GET["username"]) == mb_strtolower($results["username"])) {
    $userExists = true;
  } else {
    $userExists = false;
    
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
        <title>My Account - Trojan's Trophy Room</title>
    </head>

    <body id="body">
    <script>getURL();</script>
        <div id="contentFrame">
            <h1>Trojan's Trophy Room</h1>
            <h2 id="adminHeader">My Account</h2>
            <?php
            if ($userExists) {
                echo ("<iframe src=\"/user/account.php?username=" . $_GET["username"] . "\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);\"></iframe>");
            } else {
                echo "<p>USER NO EXISTS</p>";
            }
            ?>
                      
            <div class="subNav">
                <?php
                if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == 1) {
                    echo "<a href=\"/admin/\" class=\"subNavLink\" id=\"adminHomeButton\">ADMIN PANEL</a>";
                }
                ?>
                <a href="../" class="subNavLink" id="mainHomeButton">HOME</a>
                <p class="newLine"></p>
                <?php 
                if (isset($_SESSION["userID"])){
                    echo "<a href=\"../logout.php?redirect=\" class=\"subNavLink\" id=\"loginButton\">LOGOUT</a>";
                }
                ?>
            </div>
        </div>
    </body>
</html>