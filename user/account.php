<?php 
session_start();

include("../admin/db_config.php"); // Include database stuff

try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $username = $_GET["username"];

  $sqlGetUserDetails = $conn->prepare("SELECT * FROM " . $userTableName . " HAVING username=\"" . $username . "\"");
  //$sqlGetGameDetails = $conn->prepare("SELECT");
  $sqlGetTourneyDetails = $conn->prepare("SELECT winner1,winner2,winner3,winner4,tournamentDivision FROM " . $tournamentDataTableName . " HAVING winner1=\"" . $username . "\" OR winner2=\"" . $username . "\" OR winner3=\"" . $username . "\" OR winner4=\"" . $username . "\"");

  // Execute SQL query
  $sqlGetUserDetails->execute();
  $sqlGetTourneyDetails->execute();

  // Get user creation date
  $userDetails = $sqlGetUserDetails->fetch();
  $dateCreated = new DateTime($userDetails["userCreated"]);

  // Get tournament details
  $tourneyDetails = $sqlGetTourneyDetails->fetchAll(PDO::FETCH_ASSOC);

  // Variables to count wins
  $mainWins = 0;  // main division
  $intWins = 0;   // intermediate division
  $openWins = 0;  // open division
  foreach ($tourneyDetails as $tourneyResult) {
    if ($tourneyResult["tournamentDivision"] == "main") {
        $mainWins++;
    } else if ($tourneyResult["tournamentDivision"] == "intermediate") {
        $intWins++;
    } else if ($tourneyResult["tournamentDivision"] == "open") {
        $openWins++;
    }
  }
  $totalWins = $mainWins + $intWins + $openWins;

  // Set the displayed username to what the user signed up with
  $username = $userDetails["username"];


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
        <link rel="stylesheet" href="/styles/data.css" />
        <link rel="stylesheet" href="/styles/user_management.css" />
        <link rel="stylesheet" href="/styles/db_management.css" />
        <script src="/scripts/tools.js"></script>
        <title>User Account Management</title>
    </head>

    <body id="accountDetailsBody">
        <div id="accountDetailsPanel">
            <h3>Info</h3>
            <p class="newLine"></p>
            <div class="accountDetailsLeftSide">
                <p class="detailsBold">Username:</p>
                <p class="detailsBold">Date Joined:</p>
                <p class="detailsBold">Total trophies:</p>
                <p>&nbsp;By division</p>
                <p>&nbsp;&nbsp;&nbsp;Open:</p>
                <p>&nbsp;&nbsp;&nbsp;Intermediate:</p>
                <p>&nbsp;&nbsp;&nbsp;Main:</p>
                <p>&nbsp;</p>
            </div>
            <div class="accountDetailsRightSide">
                <p><?php echo $username ?></p>
                <p><?php echo $dateCreated->format('F j, Y'); ?></p>
                <p><?php echo $totalWins; ?></p>
                <p>&nbsp;</p>
                <p><?php echo $openWins; ?></p>
                <p><?php echo $intWins; ?></p>
                <p><?php echo $mainWins; ?></p>
                <p>&nbsp;</p>
            </div>
        </div>
        <?php
        if (mb_strtolower($username) == mb_strtolower($_SESSION["username"])) {
            echo ("
                <div id=\"accountSocialsPanel\">
                    <h3>Edit</h3>
                    <p class=\"newLine\"></p>
                    <div class=\"accountDetailsLeftSide\">
                        <p>Twitch (name):</p>
                        <p>YouTube (name):</p>
                        <p>YouTube (link):</p>
                        <p>Discord (name):</p>
                        <p>Discord (UserID):</p>
                        <p>&nbsp;</p>
                        <p><a href=\"/admin/user_management/change_password.php\" id=\"changePasswordButton\" style=\"text-align:center;\" class=\"disabled\">Change Password</a></p>
                        <p>(coming soon!)</p>
                    </div>
                    <div class=\"accountDetailsRightSide\">
                        <form id=\"editUserDetails\" action=\"/admin/user_management/edit_user.php\" method=\"post\">
                            <p><input type=\"text\" placeholder=\"" . $userDetails["twitch"] . "\" id=\"twitch\" name=\"twitch\"></p>
                            <p><input type=\"text\" placeholder=\"" . $userDetails["youtube"] . "\" id=\"youtube\" name=\"youtube\"></p>
                            <p><input type=\"text\" placeholder=\"" . $userDetails["youtubeLink"] . "\" id=\"youtubeLink\" name=\"youtubeLink\"></p>
                            <p><input type=\"text\" placeholder=\"" . $userDetails["discord"] . "\" id=\"discord\" name=\"discord\"></p>
                            <p><input type=\"text\" placeholder=\"" . $userDetails["discordLink"] . "\" id=\"discordLink\" name=\"discordLink\"></p>
                            <p>&nbsp;</p>
                            <div class=\"accountUpdateButton\">
                                <input type=\"submit\" id=\"submitButton\" value=\"Update\">
                            </div>
                        </form>
                    </div>
                </div>
            ");
        } else {
            echo ("
                <div id=\"accountSocialsPanel\">
                    <h3>Socials</h3>
                    <p class=\"newLine\"></p>
                    <div class=\"accountDetailsLeftSide\">
                        <p>Twitch:</p>
                        <p>YouTube:</p>
                        <p>Discord:</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                    </div>
                    <div class=\"accountDetailsRightSide\">
            ");
            if (isset($userDetails["twitch"]) && $userDetails["twitch"] != "") {
                echo ("<p><a href=\"#\" id=\"twitchURL\" onclick=\"redirect('twitch', '" . $userDetails["twitch"] . "')\">" . $userDetails["twitch"] . "</a></p>");
            } else {
                echo ("<p>none</p>");
            }

            if (isset($userDetails["youtube"]) && $userDetails["youtube"] != "") {
                if (isset($userDetails["youtubeLink"]) && $userDetails["youtubeLink"] != "") {
                    echo ("<p><a href=\"#\" id=\"youtubeURL\" onclick=\"redirect('youtube', '" . $userDetails["youtubeLink"] . "')\">" . $userDetails["youtube"] . "</a></p>");
                } else {
                    echo ("<p>" . $userDetails["youtube"] . "</a></p>");
                }
            } else {
                echo ("<p>none</p>");
            }

            if (isset($userDetails["discord"]) && $userDetails["discord"] != "") {
                if (isset($userDetails["discordLink"]) && $userDetails["discordLink"] != "") {
                    echo ("<a href=\"#\" id=\"discordURL\" onclick=\"redirect('discord', '" . $userDetails["discordLink"] . "')\"> " . $userDetails["discord"] . "</a></p>");
                } else {
                    echo ("<p>" . $userDetails["discord"] . "</a></p>");
                }
            } else {
                echo ("<p>none</p>");
            }
            

            echo ("
                    </div>
                </div>
            ");
        }
        ?>

    </body>
</html>