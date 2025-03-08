<?php 
include("admin/db_config.php"); // Include database

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
        <link rel="stylesheet" href="/styles/admin.css" />
        <link rel="stylesheet" href="/styles/admin_nav.css" />
        <link rel="stylesheet" href="/styles/user_management.css" />
        <script src="/scripts/tools.js"></script>
        <script>verifyPageInFrame()</script>
        <?php include ("admin/db_config.php");?> <!-- Our password-length variable is stored here -->
        <script src="/scripts/user_management.js"></script>
        <title>USER CREATION FORM</title>
        <script>var userList = <?php echo json_encode($userList); ?>; // Convert array from PHP to JS</script>
    </head>

    <body id="generalBody">
        <div id="createAccountPanel">
            <h2>Create An Account!</h2>
            <p>Get started on your trophy-winning journey with your very own TrojanDestinyRL account!</p>
            <hr>
            <p></p>
            <form id="userForm" action="/admin/user_management/add_user.php" onsubmit="return verifyInput()" method="POST" target="dataFrame" >
                <!-- THIS DIV IS FOR INPUT -->
                <div id="textInputArea">
                    <label for="username" class="inputLabel">Username:</label>
                    <input type="text" id="username" name="username" class="newLine" maxlength="30" onchange="usernameConfirm()" tabindex="1" pattern="[a-zA-Z0-9]*" required>
                    <p id="confirmUsername"></p>
                    <label for="password" class="inputLabel">Password:</label>
                    <input type="password" id="password" name="password" required tabindex="1">
                    <input type="checkbox" id="showPassword" name="showPassword" class="passwordOptions" onclick="displayPassword()"  tabindex="-1">
                    <label for="showPassword" class="passwordOptions" id="displayPassword" class="newLine">(show)</label>
                    <label for="confirmPassword" class="inputLabel">Confirm password:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" oninput="passwordConfirm()" required  tabindex="1">
                    <p id="matchingPasswords"></p>
                    <p id="matchingPasswordsText"></p>
                </div>
                <p>&nbsp;</p>
                <input type="submit" value="CREATE" tabindex="1">
            </form>
            <p>&nbsp;</p>
        </div>
    </body>
</html>