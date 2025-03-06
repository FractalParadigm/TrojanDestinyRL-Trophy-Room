<?php session_start() ?>
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
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>Connected successfully</p>";


    // Need to check if values were sent over POST, otherwise set to N/A
    if (isset($_POST["bluePlayer1"])) {
        $bluePlayer1 = $_POST["bluePlayer1"];
    } else {
        $bluePlayer1 = "N/A";
    }
    if (isset($_POST["bluePlayer2"])) {
        $bluePlayer2 = $_POST["bluePlayer2"];
    } else {
        $bluePlayer2 = "N/A";
    }
    if (isset($_POST["bluePlayer3"])) {
        $bluePlayer3 = $_POST["bluePlayer3"];
    } else {
        $bluePlayer3 = "N/A";
    }
    if (isset($_POST["bluePlayer4"])) {
        $bluePlayer4 = $_POST["bluePlayer4"];
    } else {
        $bluePlayer4 = "N/A";
    }
    if (isset($_POST["orangePlayer1"])) {
        $orangePlayer1 = $_POST["orangePlayer1"];
    } else {
        $orangePlayer1 = "N/A";
    }

    if (isset($_POST["orangePlayer2"])) {
        $orangePlayer2 = $_POST["orangePlayer2"];
    } else {
        $orangePlayer2 = "N/A";
    }

    if (isset($_POST["orangePlayer3"])) {
        $orangePlayer3 = $_POST["orangePlayer3"];
    } else {
        $orangePlayer3 = "N/A";
    }

    if (isset($_POST["orangePlayer4"])) {
        $orangePlayer4 = $_POST["orangePlayer4"];
    } else {
        $orangePlayer4 = "N/A";
    }

    $gameName = $_POST["gameName"];
    $gameDate = $_POST["gameDate"];
    $numPlayers = $_POST["numPlayers"];
    $blueScore = $_POST["blueScore"];
    $blueTeamName = $_POST["blueTeamName"];
    $orangeScore = $_POST["orangeScore"];
    $orangeTeamName = $_POST["orangeTeamName"];
    /*
    $bluePlayer1 = $_POST["bluePlayer1"];
    $bluePlayer2 = $_POST["bluePlayer2"];
    $bluePlayer3 = $_POST["bluePlayer3"];
    $bluePlayer4 = $_POST["bluePlayer4"];
    $orangePlayer1 = $_POST["orangePlayer1"];
    $orangePlayer2 = $_POST["orangePlayer2"];
    $orangePlayer3 = $_POST["orangePlayer3"];
    $orangePlayer4 = $_POST["orangePlayer4"];
    */
    $tourneyName = $_POST["tourneyName"];
    $ballchasingID = $_POST["ballchasingID"];
    $notes = $_POST["notes"];

    $uploadedBy = $_SESSION["username"];
    $uploadedByID = $_SESSION["userID"];

    if ($blueScore > $orangeScore) {
        $winningTeam = "blue";
    } elseif ($blueScore < $orangeScore) {
        $winningTeam = "orange";
    } else {
        $winningTeam = $_POST["winners"];
    }


  $insert = $conn->prepare("INSERT INTO " . $gameDataTableName . " (
  gameName, 
  gameDate, 
  uploadedBy, 
  uploadedByID, 
  numPlayers, 
  winningTeam, 
  blueScore, 
  blueTeamName, 
  orangeScore, 
  orangeTeamName, 
  bluePlayer1, 
  bluePlayer2, 
  bluePlayer3, 
  bluePlayer4, 
  orangePlayer1, 
  orangePlayer2, 
  orangePlayer3, 
  orangePlayer4, 
  tournamentName, 
  ballchasingID, 
  notes
  ) VALUES (
  :gameName, 
  :gameDate, 
  :uploadedBy, 
  :uploadedByID, 
  :numPlayers, 
  :winningTeam, 
  :blueScore, 
  :blueTeamName, 
  :orangeScore, 
  :orangeTeamName, 
  :bluePlayer1, 
  :bluePlayer2, 
  :bluePlayer3, 
  :bluePlayer4, 
  :orangePlayer1, 
  :orangePlayer2, 
  :orangePlayer3, 
  :orangePlayer4, 
  :tournamentName, 
  :ballchasingID, 
  :notes
 )");


  $insert->bindValue(":gameName", $gameName);
  $insert->bindValue(":gameDate", $gameDate);
  $insert->bindValue(":uploadedBy", $uploadedBy);
  $insert->bindValue(":uploadedByID", $uploadedByID);
  $insert->bindValue(":numPlayers", $numPlayers);
  $insert->bindValue(":winningTeam", $winningTeam);
  $insert->bindValue(":blueScore", $blueScore);
  $insert->bindValue(":blueTeamName", $blueTeamName);
  $insert->bindValue(":orangeScore", $orangeScore);
  $insert->bindValue(":orangeTeamName", $orangeTeamName);
  $insert->bindValue(":bluePlayer1", $bluePlayer1);
  $insert->bindValue(":bluePlayer2", $bluePlayer2);
  $insert->bindValue(":bluePlayer3", $bluePlayer3);
  $insert->bindValue(":bluePlayer4", $bluePlayer4);
  $insert->bindValue(":orangePlayer1", $orangePlayer1);
  $insert->bindValue(":orangePlayer2", $orangePlayer2);
  $insert->bindValue(":orangePlayer3", $orangePlayer3);
  $insert->bindValue(":orangePlayer4", $orangePlayer4);
  $insert->bindValue(":tournamentName", $tourneyName);
  $insert->bindValue(":ballchasingID", $ballchasingID);
  $insert->bindValue(":notes", $notes);



  $insert->execute();

  echo "Successfully uploaded new game record";

  } catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
  }

  $conn = null;

  ?>

</body>

</html>