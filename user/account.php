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
        <script src="/scripts/user_management.js"></script>
        <script>verifyPageInFrame()</script>
        <script>
            var head = document.getElementsByTagName('HEAD')[0];
            var link = document.createElement('link');
            link.rel = "stylesheet";
            if (parent.window.screen.width >= 360 && window.screen.width <= 1024) {
                link.href = "/styles/user_management_mobile.css";
            }
            head.appendChild(link);
        </script>
        <title>User Account Management</title>
    </head>

    <body>
        <div id="accountDetailsTitlePanel">
            <?php
            if (isset($_SESSION["userID"])) {
                if (mb_strtolower($username) == mb_strtolower($_SESSION["username"])) {
                    echo "<h2 id=\"adminHeader\">My Account</h2>";
                } else {
                    echo "<h2 id=\"adminHeader\">$username's Account</h2>";
                }
            }
            ?>
        </div>
        <p>&nbsp;</p>
        <div id="accountDetailsBody">
            <div id="accountDetailsPanel">
                <h3 class="newLine">Info</h3>
                <p></p>
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
            if (isset($_SESSION["userID"])) {
                if (mb_strtolower($username) == mb_strtolower($_SESSION["username"])) {
                    echo ("
                        <div id=\"accountSocialsPanel\">
                            <h3 class=\"newLine\">Edit</h3>
                            <p></p>
                            <div class=\"accountDetailsLeftSide\">
                                <p>Twitch (name):</p>
                                <p>YouTube (name):</p>
                                <p>YouTube (link):</p>
                                <p>Discord (name):</p>
                                <p>Discord (UserID):</p>
                                <p>&nbsp;</p>
                                <p><a id=\"changePasswordButton\" style=\"text-align:center;\" onclick=\"togglePWChange();\">Change Password</a></p>
                                <p>&nbsp;</p>
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
                        "/*                                    */ . "
                        "/*           PASSWORD CHANGE          */ . "
                        "/*                                    */ . "
                        <div id=\"passwordChangePanel\">
                            <h3 class=\"newLine\">Change Password</h3>
                            <p></p>
                            <div class=\"accountDetailsLeftSide\">
                                <p>Old Password:</p>
                                <p>&nbsp;</p>
                                <p>New Password:</p>
                                <p>Confirm:</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p><a id=\"changePasswordButton\" style=\"text-align:center;\" onclick=\"togglePWChange()\">Back</a></p>
                                <p>&nbsp;</p>
                            </div>
                            <div class=\"accountDetailsRightSide\">
                                <form id=\"passwordChangeForm\" action=\"/admin/user_management/change_password.php\" method=\"post\">
                                    <p><input type=\"password\" id=\"oldPassword\" name=\"oldPassword\"></p>
                                    <p>&nbsp;</p>
                                    <p><input type=\"password\" id=\"password\" name=\"password\" oninput=\"checkPasswordRequirements();\"></p>
                                    <p><input type=\"password\" id=\"confirmPassword\" name=\"confirmPassword\" oninput=\"passwordConfirmLite();\"></p>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    <div class=\"accountUpdateButton\">
                                        <input type=\"submit\" id=\"passwordChangeButton\" value=\"Change\">
                                    </div>
                                </form>
                            </div>
                        </div>
                    ");
                }  else {
                    echo ("
                        <script>console.log('test');</script>
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
                        echo ("<p><a href=\"#\" id=\"twitchURL\" onclick=\"redirect('twitch', '" . $userDetails["twitch"] . "')\" class=\"plainLinkBlue\">" . $userDetails["twitch"] . "</a></p>");
                    } else {
                        echo ("<p>none</p>");
                    }
    
                    if (isset($userDetails["youtube"]) && $userDetails["youtube"] != "") {
                        if (isset($userDetails["youtubeLink"]) && $userDetails["youtubeLink"] != "") {
                            echo ("<p><a href=\"#\" id=\"youtubeURL\" onclick=\"redirect('youtube', '" . $userDetails["youtubeLink"] . "')\" class=\"plainLinkBlue\">" . $userDetails["youtube"] . "</a></p>");
                        } else {
                            echo ("<p>" . $userDetails["youtube"] . "</a></p>");
                        }
                    } else {
                        echo ("<p>none</p>");
                    }
    
                    if (isset($userDetails["discord"]) && $userDetails["discord"] != "") {
                        if (isset($userDetails["discordLink"]) && $userDetails["discordLink"] != "") {
                            echo ("<a href=\"#\" id=\"discordURL\" onclick=\"redirect('discord', '" . $userDetails["discordLink"] . "')\" class=\"plainLinkBlue\"> " . $userDetails["discord"] . "</a></p>");
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
            } else {
                echo ("
                    <script>console.log('test');</script>
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
                    echo ("<p><a href=\"#\" id=\"twitchURL\" onclick=\"redirect('twitch', '" . $userDetails["twitch"] . "')\" class=\"plainLinkBlue\">" . $userDetails["twitch"] . "</a></p>");
                } else {
                    echo ("<p>none</p>");
                }

                if (isset($userDetails["youtube"]) && $userDetails["youtube"] != "") {
                    if (isset($userDetails["youtubeLink"]) && $userDetails["youtubeLink"] != "") {
                        echo ("<p><a href=\"#\" id=\"youtubeURL\" onclick=\"redirect('youtube', '" . $userDetails["youtubeLink"] . "')\" class=\"plainLinkBlue\">" . $userDetails["youtube"] . "</a></p>");
                    } else {
                        echo ("<p>" . $userDetails["youtube"] . "</a></p>");
                    }
                } else {
                    echo ("<p>none</p>");
                }

                if (isset($userDetails["discord"]) && $userDetails["discord"] != "") {
                    if (isset($userDetails["discordLink"]) && $userDetails["discordLink"] != "") {
                        echo ("<a href=\"#\" id=\"discordURL\" onclick=\"redirect('discord', '" . $userDetails["discordLink"] . "')\" class=\"plainLinkBlue\"> " . $userDetails["discord"] . "</a></p>");
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
        </div>
    </body>
</html>