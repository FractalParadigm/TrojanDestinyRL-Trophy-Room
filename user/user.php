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
  if (isset($results)) {
    if (mb_strtolower($_GET["username"]) != mb_strtolower($results["username"])) {
        $userExists = false;
    } else {
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
        <title>My Account - Trojan's Trophy Room</title>
    </head>

    <body id="body">
    <script>getURL();</script>
        <div id="contentFrame">
            <div class="header">
                <div id="headerLeft">
                    <img src="/assets/trojan_image_1.png" alt="Trojan Destiny logo" id="headerImage">
                </div>
                <div id="headerCentre">
                <h1 id="headerText"><a href="/" class="plainLinkBlue">TrojanDestinyRL</a></h1>
                    <div id="youtubeImage" onclick="redirect('this', 'https://www.youtube.com/@TrojanDestinyRL')"><img src="/assets/youtube.svg" alt="youtube logo"></div>
                    <div id="twitchImage" onclick="redirect('this', 'https://www.twitch.tv/trojandestinyrl')"><img src="/assets/twitch.svg" alt="twitch logo"></div>
                    <div id="discordImage" onclick="redirect('this', 'https://discord.gg/bzU5fVxCZJ')"><img src="/assets/discord.svg" alt="discord logo"></div>
                </div>
                <div id="headerRight">
                <img src="/assets/trojan_image_2.png" alt="Trojan Destiny logo" id="headerImage">
                </div>
            </div>
            <p></p>
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
                      
            <div class="subNav">
                <?php
                if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == 1) {
                    echo "<a href=\"/admin/\" class=\"subNavLink\" id=\"adminHomeButton\">ADMIN PANEL</a>";
                }
                ?>
                <a href="../" class="subNavLink" id="mainHomeButton">HOME</a>

                <?php
                // If we're showing someone other than who's logged in, offer a link to their own page
                if (isset($_SESSION["userID"]) && $_SESSION["username"] != $_GET["username"]){
                echo "<a href=\"/user/" . $_SESSION["username"] . " \" class=\"subNavLink\">MY ACCOUNT</a>";
                }
                ?>

                <p class="newLine"></p>
                <?php 
                // If someone is logged in, give them the opportunity to log out
                if (isset($_SESSION["userID"])){
                    echo "<a href=\"../logout.php?redirect=\" class=\"subNavLink\" id=\"loginButton\">LOGOUT</a>";
                } else {
                    echo "<a href=\"/login_page.php \" target=\"dataFrame\" class=\"subNavLink\">SIGN IN</a>";
                    echo "<a href=\"/create_account.php \" target=\"dataFrame\" class=\"subNavLink\">CREATE AN ACCOUNT</a>";
                }
                ?>
            </div>
        </div>
    </body>
</html>