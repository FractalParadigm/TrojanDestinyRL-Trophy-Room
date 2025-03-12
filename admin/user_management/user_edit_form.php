<?php 
include("../db_config.php"); // Include database

// This grabs the list of users to check and make sure we aren't creating duplicates

try {  // Try opening the SQL database connection
  $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $username = $_GET["username"];

  // Grab the list of users from the user list
  $sqlGetUserData = $conn->prepare("SELECT * FROM " . $userTableName . " WHERE username=\"" . $username . "\"");
  

  // Execute SQL query
  $sqlGetUserData->execute();

  // Get results
  $userData = $sqlGetUserData->fetch();


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
        <link rel="stylesheet" href="/styles/admin.css" />
        <link rel="stylesheet" href="/styles/admin_nav.css" />
        <link rel="stylesheet" href="/styles/user_management.css" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
        <script src="/scripts/user_management.js"></script>
        <script src="/scripts/tools.js"></script>
        <script>verifyPageInFrame()</script>
        <title>USER EDITING FORM</title>
    </head>

    <body id="userEditBody">
        <div id="userEditPanel">
            <p>&nbsp;</p>
            <hr >
            <form id="userForm" action="edit_user.php" onsubmit="return verifyInput()" method="POST" target="dataFrame">
                <!-- THIS DIV IS FOR INPUT -->
                <div id="textInputArea">
                    <label for="discord" class="newLine">Discord:</label>
                    <input type="text" placeholder="<?php echo $userData["discord"] ?>" id="discord" name="discord" class="newLine" style="width:100%" maxlength="50"/>
                    <label for="discord" class="newLine">Discord Link:</label>
                    <input type="text" placeholder="<?php echo $userData["discordLink"] ?>" id="discordLink" name="discordLink" class="newLine" style="width:100%" pattern="[0-9]*" maxlength="50"/>
                    <label for="twitch" class="newLine">Twitch:</label>
                    <input type="text" placeholder="<?php echo $userData["twitch"] ?>" id="twitch" name="twitch" class="newLine" style="width:100%" maxlength="50" />
                    <label for="youtube" class="newLine">Youtube:</label>
                    <input type="text" placeholder="<?php echo $userData["youtube"] ?>" id="youtube" name="youtube" class="newLine" style="width:100%" maxlength="50" />
                    <label for="youtube" class="newLine">Youtube Link:</label>
                    <input type="text" placeholder="<?php echo $userData["youtubeLink"] ?>" id="youtubeLink" name="youtubeLink" class="newLine" style="width:100%" maxlength="50" />
                </div>
                <hr>
                <!-- THIS DIV IS FOR EXTRA SETTINGS -->
                <div id="extraOptions">
                    <h4>EXTRA OPTIONS</h4>
                    <h5 class="newLine underlined bolded larger">User Type</h5>
                    <p class="newLine"></p>
                    <input type="radio" id="regular" name="privileges" value="regular" class="extraOptions">
                    <label for="regular" class="extraOptions">Regular</label>
                    <input type="radio" id="moderator" name="privileges" value="moderator" class="extraOptions">
                    <label for="moderator" class="extraOptions">Moderator</label>
                    <input type="radio" id="administrator" name="privileges" value="administrator" class="extraOptions">
                    <label for="administrator" class="extraOptions">Administrator</label>
                    <p class="newLine">&nbsp;</p>
                    <p class="newLine"><span class="bolded">Moderators:</span> More details coming soon</p>
                    <p class="newLine"><span class="bolded">Administrators:</span> Have FULL access to the admin panel</p>
                </div>
                <p>&nbsp;</p>
                <input type="submit" value="EDIT" />
                <input type="hidden" id="username" name="username" value="<?php echo $username; ?>" >
            </form>
            <script>setPrivilegeLevel(<?php echo $userData["privileges"]; ?>)</script>

            <div id="userEditFrameDiv">
            
            </div>

            <p>&nbsp;</p>
        </div>
    </body>
</html>