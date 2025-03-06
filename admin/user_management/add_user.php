<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="/styles/primary.css" />
  <link rel="stylesheet" href="/styles/db_management.css" />
  <title>no title</title>
</head>

<body class="sqlOutput">
  <?php
  // USER-DEFINED VARIABLES
  include("../db_config.php"); // Include database stuff


  try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Double-check to make sure the user isn't already in the database, i.e. if the user re-submits the form

      // Check if the user exists
  $sqlUserCheck = $conn->prepare("SELECT username FROM " . $userTableName . "");

  // Execute SQL query
  $sqlUserCheck->execute();

  // Get results from the USERS table
  $results = $sqlUserCheck->fetch();

  // Check if user exists
  if (mb_strtolower($_GET["username"]) == mb_strtolower($results["username"])) {
    // USER ALREADY EXISTS
      echo "<div class=userMessage>";
      echo "<p>Fatal error</p>";
      echo "<p>Please go to the home page and try what you were doing again</p>";
      echo "<p>&nbsp;</p>";
      echo "<a href=\"/\" class=\"subNavLink\">HOME</a>";
      echo "</div>";
  } else {
    // USER DOES NOT EXIST
    // Variables for the various input fields
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);  // Hash the password for security
    $discord = $_POST["discord"];
    $discordLink = $_POST["discordLink"];
    $twitch = $_POST["twitch"];
    $youtube = $_POST["youtube"];
    $youtubeLink = $_POST["youtubeLink"];

    $isAdmin = 0;

    if (filter_has_var(INPUT_POST, "isAdmin")) {
      $isAdmin = 1;
    }

    $insert = $conn->prepare("INSERT INTO " . $userTableName . " (username, password, discord, discordLink, twitch, youtube, youtubeLink, isAdmin) VALUES (:username, :password, :discord, :discordLink, :twitch, :youtube, :youtubeLink, :isAdmin)");


    $insert->bindParam(":username", $username);
    $insert->bindParam(":password", $password);
    $insert->bindParam(":discord", $discord);
    $insert->bindParam(":discordLink", $discordLink);
    $insert->bindParam(":twitch", $twitch);
    $insert->bindParam(":youtube", $youtube);
    $insert->bindParam(":youtubeLink", $youtubeLink);

    $insert->bindParam(":isAdmin", $isAdmin);

    $insert->execute();
    if ($isAdmin == 1) {
      echo "New admin user \"" . $username . "\" created successfully";
    } else {
      echo "<div class=userMessage>";
      echo "<p>Account created! You may sign in now.</p>";
      echo "<p>&nbsp;</p>";
      echo "<a href=\"/\" class=\"subNavLink\">HOME</a>";
      echo "<a href=\"/login_page.php\" target=\"dataFrame\" class=\"subNavLink\">SIGN IN</a>";
      echo "<p>&nbsp;</p>";
      echo "</div>";
    }

  }


  } catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
  }

  $conn = null;

  ?>

</body>

</html>