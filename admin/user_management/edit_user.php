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


    // Grab username to make sure we're updating the person logged in
    if (isset ($_POST["username"])) {
      // If there was a username sent via POST i.e. we're editing a user
      $username = $_POST["username"];
    } else {
      // otherwise use the person logged in
      $username = $_SESSION["username"];
    }


    // Grab the existing data, so we can only update the things that got updated
    $sqlGetUserInfo = $conn->prepare("SELECT * FROM " . $userTableName . " WHERE username=\"" . $username . "\"");
    $sqlGetUserInfo->execute();

    $userInfo = $sqlGetUserInfo->fetch(); // fetch row

    // These IF blocks check if the data entered is different from the data already in the DB
    // If the information is the same then we copy the stuff over, otherwise write it

    if ($_POST["twitch"] != $userInfo["twitch"] && $_POST["twitch"] != "") {
        $twitch = $_POST["twitch"];
    } else {
        $twitch = $userInfo["twitch"];
    }
    echo $twitch;
    echo "<p></p>";

    if ($_POST["youtube"] != $userInfo["youtube"] && $_POST["youtube"] != "") {
        $youtube = $_POST["youtube"];
    } else {
        $youtube = $userInfo["youtube"];
    }
    echo $youtube;
    echo "<p></p>";

    if ($_POST["youtubeLink"] != $userInfo["youtubeLink"] && $_POST["youtubeLink"] != "") {
        $youtubeLink = $_POST["youtubeLink"];
    } else {
        $youtubeLink = $userInfo["youtubeLink"];
    }
    echo $youtubeLink;
    echo "<p></p>";

    if ($_POST["discord"] != $userInfo["discord"] && $_POST["discord"] != "") {
        $discord = $_POST["discord"];
    } else {
        $discord = $userInfo["discord"];
    }
    echo $discord;
    echo "<p></p>";

    if ($_POST["discordLink"] != $userInfo["discordLink"] && $_POST["discordLink"] != "") {
        $discordLink = $_POST["discordLink"];
    } else {
        $discordLink = $userInfo["discordLink"];
    }
    echo $discordLink;
    echo "<p></p>";


    if ($_POST["administrator"] != $userInfo["privileges"]) {
      $privileges = 1;
    } else {
      $privileges = $userInfo["privileges"];
    }
    if ($_POST["moderator"] != $userInfo["privileges"]) {
      $privileges = 2;
    } else {
      $privileges = $userInfo["privileges"];
    }

   // Prepare the command
    $update = $conn->prepare("UPDATE " . $userTableName . " SET 
    privileges = :privileges,
    twitch = :twitch, 
    youtube = :youtube, 
    youtubeLink = :youtubeLink,
    discord = :discord, 
    discordLink = :discordLink 
    WHERE username = :username
    ");

    // Bind parameters to query
    $update->bindParam(":username", $username);
    $update->bindParam(":privileges", $privileges);
    $update->bindParam(":twitch", $twitch);
    $update->bindParam(":youtube", $youtube);
    $update->bindParam(":youtubeLink", $youtubeLink);
    $update->bindParam(":discord", $discord);
    $update->bindParam(":discordLink", $discordLink);

    $update->execute(); // Execute query

    
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

    // Redirect user back to their page
    echo "<script>window.top.location.href = \"" . $address . "\";</script>";

    echo "<p>Account successfully updated</p>";
    echo "<p>You should have been redirected to your account. Here's a link:</p>";
    echo "<p><a href=\"/user/" . $_SESSION["username"] . " \">My Account</a></p>";


  } catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
  }

  $conn = null;

  ?>

</body>

</html>