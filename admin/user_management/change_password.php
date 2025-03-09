<?php session_start() ?>
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


  try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // Grab session username to make sure we're updating the person logged in
    $username = $_SESSION["username"];


    // Grab the existing data, so we can only update the things that got updated
    $sqlGetUserInfo = $conn->prepare("SELECT password FROM " . $userTableName . " WHERE username=\"" . $username . "\"");
    $sqlGetUserInfo->execute();

    $userInfo = $sqlGetUserInfo->fetch(); // fetch row

    // Grab passwords entered on account page
    $oldPassword = $_POST["oldPassword"];
    $newPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Grab the hashed password from the database
    $passwordHash = $userInfo["password"];


    // Function from StackOverflow used to get the base URL, to which we append
    // the redirect (where the user came from)
    function url(){
        return sprintf(
          "%s://%s/user/%s",
          isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
          $_SERVER['SERVER_NAME'],
          $_SESSION["username"]
        );
      }

      $address = url();

    // Make sure the old password(s) match
    if (password_verify($oldPassword, $passwordHash)) {

        // Prepare the command
        $update = $conn->prepare("UPDATE " . $userTableName . " SET 
        password = :password
        WHERE username = :username
        ");

        // Bind parameters to query
        $update->bindParam(":username", $username);
        $update->bindParam(":password", $newPassword);

        $update->execute(); // Execute query
        
        // Tell the user what we did
        echo "<h3>Password successfully changed!</h3>";
        echo "<p><a href=\"/user/" . $_SESSION["username"] . " \" onclick=\"redirect('this', '/user/" . $username . "')\">This link will take you back to your account</a></p>";
        echo "<p>Or, you will be re-directed automatically in 5 seconds...</p>";
        echo "<script>setTimeout(() => {window.top.location.href = \"" . $address . "\";}, 5000);</script>";
    } else {
        // Or tell them something fucked up
        echo "<h3>Whoops!</h3>";
        echo "<p>There was a problem and your password couldn't be updated. Make sure you've typed your old password correctly and try again</p>";
        echo "<p><a href=\"/user/" . $_SESSION["username"] . " \" onclick=\"redirect('this', '/user/" . $username . "')\">This link will take you back to your account</a></p>";
        echo "<p>Or, you will be re-directed automatically in 5 seconds...</p>";
        echo "<script>setTimeout(() => {window.top.location.href = \"" . $address . "\";}, 5000);</script>";
    }




  } catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
  }

  $conn = null;

  ?>

</body>

</html>