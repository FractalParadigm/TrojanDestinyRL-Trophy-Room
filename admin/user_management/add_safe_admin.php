<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="/styles/primary.css" />
  <link rel="stylesheet" href="/styles/db_management.css" />
  <script src="/scripts/tools.js"></script>
  <script>verifyPageInFrame()</script>
  <title>no title</title>
</head>

<body class="sqlOutput">
  <?php
  // USER-DEFINED VARIABLES
  include("../db_config.php"); // Include database stuff
  include("../db_management/initialise.php");


  try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // Check if the users table exists already
    $sqlCheckAdminUserTable = $conn->prepare("SHOW TABLES LIKE '" . $adminUserTableName . "'");
  
    // Run the query
    $sqlCheckAdminUserTable->execute();
  
    //Check if any rows exist - if not, create the table
    $adminCount = $sqlCheckAdminUserTable->rowCount();

    if ($adminCount == 0) {
      echo "<p>Admins table not found! This is probably initial setup.</p><p>Creating safe admins table...</p>";
        try {
          $conn->query($sqlCreateAdminTable);
          echo "<p>Table '" . $adminUserTableName . "' successfully created (safe admins)</p>";
        } catch (PDOException $e) {
          echo $sqlCreateUserTable . "<br>" . $e->getMessage();
        }
    }
    

    // Variables for the various input fields
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);  // Hash the password for security
    $twitch = $_POST["twitch"];
    $discord = $_POST["discord"];
    $discordLink = $_POST["discordLink"];
    $youtube = $_POST["youtube"];
    $youtubeLink = $_POST["youtubeLink"];

    // Gotta check and make sure the user we're creating is an admin
    $isAdmin = 0;

    if (filter_has_var(INPUT_POST, "isAdmin")) {
      $isAdmin = 1;
    }

    // Prepare the query
    $insert = $conn->prepare("INSERT INTO " . $adminUserTableName . " (username, password, discord, discordLink, twitch, youtube, youtubeLink, isAdmin) VALUES (:username, :password, :discord, :discordLink, :twitch, :youtube, :youtubeLink, :isAdmin)");

    // Bind parameters to the query
    $insert->bindParam(":username", $username);
    $insert->bindParam(":password", $password);
    $insert->bindParam(":discord", $discord);
    $insert->bindParam(":discordLink", $discordLink);
    $insert->bindParam(":twitch", $twitch);
    $insert->bindParam(":youtube", $youtube);
    $insert->bindParam(":youtubeLink", $youtubeLink);
    $insert->bindParam(":isAdmin", $isAdmin);

    // Execute
    $insert->execute();

    // Check if users table exists, if not run the initialize script, otherwise just make the user

    $sqlCheckUserTable = $conn->prepare("SHOW TABLES LIKE " . $userTableName);

    // Run the query, if the table doesn't exist, initialize the database first
    if ($sqlCheckUserTable !== false && $sqlCheckUserTable->rowCount() > 0) {
        echo "<p>Users table found</p>";
    
      // Now add them to the regular users table as well
      // Prepare the query
      $insert = $conn->prepare("INSERT INTO " . $userTableName . " (username, password, discord, discordLink, twitch, youtube, youtubeLink, isAdmin) VALUES (:username, :password, :discord, :discordLink, :twitch, :youtube, :youtubeLink, :isAdmin)");

      // Bind parameters to the query
      $insert->bindParam(":username", $username);
      $insert->bindParam(":password", $password);
      $insert->bindParam(":discord", $discord);
      $insert->bindParam(":discordLink", $discordLink);
      $insert->bindParam(":twitch", $twitch);
      $insert->bindParam(":youtube", $youtube);
      $insert->bindParam(":youtubeLink", $youtubeLink);
      $insert->bindParam(":isAdmin", $isAdmin);

      // Execute
      $insert->execute();
    } else {
      echo "<p>Users table not found! This is probably (still) initial setup. Creating...</p>";

      initialiseDatabase();


      // Next we're going to copy any safe admins into the users table.
      // This will make userlists easier to work with
      //echo "<p>Copying users from safe admins...</p>";
      //$copyAdmins = $conn->prepare("INSERT INTO " . $userTableName . " SELECT * FROM " . $adminUserTableName);
    
      //$copyAdmins->execute();
      //echo "<p>Copied!</p>";
    }

    
    if ($userCount == 0) {
    } else {
    }




    echo "Safe Admin created successfully!";

  } catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
  }

  $conn = null;

  ?>

</body>

</html>