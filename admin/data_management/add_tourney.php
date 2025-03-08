<?php session_start() ?>
<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
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


    // Need to check if values were sent over POST, otherwise set to N/A
    if (isset($_POST["winningPlayer1"])) {
        $winningPlayer1 = $_POST["winningPlayer1"];
    } else {
        $winningPlayer1 = "N/A";
    }
    if (isset($_POST["winningPlayer2"])) {
        $winningPlayer2 = $_POST["winningPlayer2"];
    } else {
        $winningPlayer2 = "N/A";
    }
    if (isset($_POST["winningPlayer3"])) {
        $winningPlayer3 = $_POST["winningPlayer3"];
    } else {
        $winningPlayer3 = "N/A";
    }
    if (isset($_POST["winningPlayer4"])) {
        $winningPlayer4 = $_POST["winningPlayer4"];
    } else {
        $winningPlayer4 = "N/A";
    }

    $tourneyName = $_POST["tourneyName"];
    $tourneyDate = $_POST["tourneyDate"];
    $division = $_POST["division"];
    $numPlayers = $_POST["numPlayers"];
    $bestOf = $_POST["bestOf"];
    $winningTeamName = $_POST["winningTeamName"];
    $notes = $_POST["notes"];

    echo "<p>$tourneyName</p>";
    echo "<p>$tourneyDate</p>";
    echo "<p>$division</p>";
    echo "<p>$numPlayers</p>";
    echo "<p>$bestOf</p>";
    echo "<p>$winningTeamName</p>";
    echo "<p>$winningPlayer1</p>";
    echo "<p>$winningPlayer2</p>";
    echo "<p>$winningPlayer3</p>";
    echo "<p>$winningPlayer4</p>";
    echo "<p>$notes</p>";


  $insert = $conn->prepare("INSERT INTO " . $tournamentDataTableName . " (
  tournamentName,
  tournamentDate,
  tournamentDivision,
  numPlayers,
  bestOf,
  winningTeamName,
  winner1,
  winner2,
  winner3,
  winner4,
  notes
  ) VALUES (
  :tournamentName,
  :tournamentDate,
  :tournamentDivision,
  :numPlayers,
  :bestOf,
  :winningTeamName,
  :winner1,
  :winner2,
  :winner3,
  :winner4,
  :notes
 )");


  $insert->bindValue(":tournamentName", $tourneyName);
  $insert->bindValue(":tournamentDate", $tourneyDate);
  $insert->bindValue(":tournamentDivision", $division);
  $insert->bindValue(":numPlayers", $numPlayers);
  $insert->bindValue(":bestOf", $bestOf);
  $insert->bindValue(":winningTeamName", $winningTeamName);
  $insert->bindValue(":winner1", $winningPlayer1);
  $insert->bindValue(":winner2", $winningPlayer2);
  $insert->bindValue(":winner3", $winningPlayer3);
  $insert->bindValue(":winner4", $winningPlayer4);
  $insert->bindValue(":notes", $notes);



  $insert->execute();

  echo "Successfully uploaded new tournament record";

  } catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
  }

  $conn = null;

  ?>

</body>

</html>