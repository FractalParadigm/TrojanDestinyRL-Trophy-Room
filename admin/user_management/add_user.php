<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="/styles/db_management.css" />
  <title>no title</title>
</head>

<body class="sqlOutput">
  <?php
  // USER-DEFINED VARIABLES
  include("../db_config.php"); // Include database stuff


  try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Variables for the various input fields
  $username = $_POST["username"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);  // Hash the password for security
  $discord = $_POST["discord"];
  $twitch = $_POST["twitch"];
  $youtube = $_POST["youtube"];

  $isAdmin = 0;

  if (filter_has_var(INPUT_POST, "isAdmin")) {
    $isAdmin = 1;
  }

  $insert = $conn->prepare("INSERT INTO " . $userTableName . " (username, password, discord, twitch, youtube, isAdmin) VALUES (:username, :password, :discord, :twitch, :youtube, :isAdmin)");


  $insert->bindParam(":username", $username);
  $insert->bindParam(":password", $password);
  $insert->bindParam(":discord", $discord);
  $insert->bindParam(":twitch", $twitch);
  $insert->bindParam(":youtube", $youtube);

  $insert->bindParam(":isAdmin", $isAdmin);

  $insert->execute();
  if ($isAdmin == 1) {
    echo "New admin user \"" . $username . "\" created successfully";
  } else {
    echo "New user \"" . $username . "\" created successfully";
  }

  } catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
  }

  $conn = null;

  ?>

</body>

</html>