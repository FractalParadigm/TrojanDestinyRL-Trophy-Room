<?php 
include("../db_config.php"); // Include database

// This grabs the list of users to check and make sure we aren't creating duplicates

try {  // Try opening the SQL database connection
  $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Grab the list of users from the user list
  $sqlGetUserData = $conn->prepare("SELECT username FROM " . $userTableName . "");
  

  // Execute SQL query
  $sqlGetUserData->execute();

  // Get results from the USERS table
  $results = $sqlGetUserData->fetchAll(PDO::FETCH_ASSOC);

  // Create array to store values
  $userList = array();
  
  // Move results to their own array, easier to convert for Javascript
  foreach ($results as $result) {
    $userList[] = $result["username"];
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
        <link rel="stylesheet" href="/styles/admin.css" />
        <link rel="stylesheet" href="/styles/admin_nav.css" />
        <link rel="stylesheet" href="/styles/user_management.css" />
        <script src="/scripts/user_management.js"></script>
        <script src="/scripts/tools.js"></script>
        <script>verifyPageInFrame()</script>
        <script>var userList = <?php echo json_encode($userList); ?>; // Convert array from PHP to JS</script>
        <title>USER CREATION FORM</title>
    </head>

    <body id="generalBody">
        <div id="userFormPanel">
            <h2>USER CREATION</h2>
            <p>This form is used to manually add new users to the system</p>
            <hr>
            <p></p>
            <form id="userForm" action="add_user.php" onsubmit="return verifyInput()" method="POST" target="dataFrame">
                <!-- THIS DIV IS FOR INPUT -->
                <div id="textInputArea">
                    <label for="username" class="inputLabel" >Username:</label>
                    <input type="text" id="username" name="username" class="newLine" maxlength="30" oninput="usernameConfirm()" tabindex="1" pattern="[a-zA-Z0-9-_\|.]*" required>
                    <p id="confirmUsername"></p>
                    <label for="password" class="inputLabel newLine">Password:</label>
                    <input type="password" id="password" name="password" minlength="6" oninput="checkPasswordRequirements()" required/>
                    <input type="checkbox" id="showPassword" name="showPassword" class="passwordOptions" onclick="displayPassword()"/>
                    <label for="showPassword" class="passwordOptions" id="displayPassword" class="newLine">(show)</label>
                    <label for="discord" class="newLine">Discord:</label>
                    <input type="text" id="discord" name="discord" class="newLine"  maxlength="50"/>
                    <label for="discord" class="newLine">Discord Link:</label>
                    <input type="text" id="discordLink" name="discordLink" class="newLine"  maxlength="50"/>
                    <label for="twitch" class="newLine">Twitch:</label>
                    <input type="text" id="twitch" name="twitch" class="newLine" maxlength="50" />
                    <label for="youtube" class="newLine">Youtube:</label>
                    <input type="text" id="youtube" name="youtube" class="newLine" maxlength="50" />
                    <label for="youtube" class="newLine">Youtube Link:</label>
                    <input type="text" id="youtubeLink" name="youtubeLink" class="newLine" maxlength="50" />
                </div>
                <hr>
                <!-- THIS DIV IS FOR EXTRA SETTINGS -->
                <div id="extraOptions">
                    <h4>EXTRA OPTIONS</h4>
                    <p class="newLine">&nbsp;</p>
                    <h5 class="newLine underlined bolded larger">User Type</h5>
                    <p class="newLine"></p>
                    <input type="radio" id="regular" name="privileges" value="regular" class="extraOptions" checked>
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
                <input type="submit" value="CREATE" />
            </form>
            <p>&nbsp;</p>
        </div>
    </body>
</html>