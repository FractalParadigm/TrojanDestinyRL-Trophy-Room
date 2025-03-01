<?php 
session_start();
?>

<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="db_management.css" />
  <link rel="stylesheet" href="login.css" />
  <!-- <script src="trojan.js"></script>-->
  <title>no title</title>
</head>

<body class="sqlOutput">
  <?php
  // USER-DEFINED VARIABLES
  include("admin/db_config.php"); // Include database stuff

  try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get username and password out of the POST data
    $username = $_POST["username"];
    $password = $_POST["password"];



    // THIS SHOULD BE MADE MORE EFFICIENT WITH ONLY ONE QUERY IF POSSIBLE
    // Grab the password hash for the username (if available)
    $sqlGetPasswordHash = $conn->prepare("SELECT password FROM " . $userTableName . " WHERE username=\"" . $username . "\"");
    $sqlGetUserID = $conn->prepare("SELECT userID FROM " . $userTableName . " WHERE username=\"" . $username . "\"");
    $sqlGetisAdmin = $conn->prepare("SELECT isAdmin FROM " . $userTableName . " WHERE username=\"" . $username . "\"");

    $sqlGetPasswordHash->execute();
    $sqlGetUserID->execute();
    $sqlGetisAdmin->execute();
    

  } catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
  }

  // Grab the hash from the fetched SQL data
$passwordHash = $sqlGetPasswordHash->fetchColumn();
$userID = $sqlGetUserID->fetchColumn();
$isAdmin = $sqlGetisAdmin->fetchColumn();


// Verify that the entered password matches the hashed one
if (password_verify($password, $passwordHash)) {
    echo "<p>Welcome $username, please wait while we redirect you...</p>";
    $_SESSION["userID"] = $userID;
    $_SESSION["username"] = $username;
    $_SESSION["isAdmin"] = $isAdmin;
    // Function from StackOverflow used to get the base URL, to which we append
    // the redirect (where the user came from)
    function url(){
        return sprintf(
          "%s://%s/%s",
          isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
          $_SERVER['SERVER_NAME'],
          $_GET["redirect"]
        );
      }

      $address = url();
      echo "<p>$address</p>";
    
      echo "<script>window.top.location.href = \"" . $address . "\";</script>";
      
} else {
    echo "<p>Invalid credentials</p>";
}


// Close the SQL connection
  $conn = null;

  ?>

</body>

</html>