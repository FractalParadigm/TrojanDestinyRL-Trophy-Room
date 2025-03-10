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
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
        <script src="/scripts/user_management.js"></script>
        <script src="/scripts/tools.js"></script>
        <script>verifyPageInFrame()</script>
        <script>
        var userList = <?php echo json_encode($userList); ?>; // Convert array from PHP to JS
        $( function() {
            $("#user").autocomplete({
                source: userList,
                // This only allows listed items to be chosen
                change: function (event, ui) {
                    if(!ui.item) {
                        $("#user").val("");
                    }
                }
            });
        } );
        </script>
        <title>USER CREATION FORM</title>
    </head>

    <body id="generalBody">
        <div id="userEditPanel">
            <h2>USER EDITING</h2>
            <p>Edit users here</p>
            <hr>
            <p></p>

            <div id="textInputArea" class="userForm">
                <label for="user">User:</label>
                <input type="text" id="user" name="user" maxlength="30" tabindex="1" >
                <button value="SEARCH" class="normalButton" onclick="editUser()">SEARCH</button>
            </div>

            <div id="userEditFrameDiv">
            
            </div>

            <p>&nbsp;</p>
        </div>
    </body>
</html>