<?php 
session_start();
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="/styles/primary.css" />
        <link rel="stylesheet" href="/styles/data.css" />
        <link rel="stylesheet" href="/styles/data_display.css" />
        <script src="/scripts/tools.js"></script>
        <script>verifyPageInFrame()</script>
        <title>GENERAL DATA</title>
    </head>

    <?php
    include("../admin/db_config.php");

    try {  // Try opening the SQL database connection
        $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Grab all our tourney and game results
        // Prepare SQL
        $sqlGetTourneyData = $conn->prepare("SELECT * FROM " . $tournamentDataTableName);
        $sqlGetGameData = $conn->prepare("SELECT * FROM " . $gameDataTableName);
        $sqlGetUserData = $conn->prepare("SELECT username FROM " . $userTableName);

        // Execute
        $sqlGetTourneyData->execute();
        $sqlGetGameData->execute();
        $sqlGetUserData->execute();

        // fetch rows
        $tourneyData = $sqlGetTourneyData->fetchAll(PDO::FETCH_ASSOC);
        $gameData = $sqlGetGameData->fetchAll(PDO::FETCH_ASSOC);
        $userData = $sqlGetUserData->fetchAll(PDO::FETCH_NUM);

        // Initalize arrays to store tournament winner counts
        // Total count
        $totalTourneyWinners = array();
        $openTourneyWinners = array();
        $intermediateTourneyWinners = array();
        $mainTourneyWinners = array();

        // Check the number of players for each entry
        // Then, grab that many winners
        foreach ($tourneyData as $data) {
            for ($i = 1; $i <= $data["numPlayers"]; $i++) {
                $winnerIndex = "winner" . $i;
                $totalTourneyWinners[] = $data[$winnerIndex];
                if ($data["tournamentDivision"] == "open") {
                    $openTourneyWinners[] = $data[$winnerIndex];
                } 
                if ($data["tournamentDivision"] == "intermediate") {
                    $intermediateTourneyWinners[] = $data[$winnerIndex];
                }
                if ($data["tournamentDivision"] == "main") {
                    $mainTourneyWinners[] = $data[$winnerIndex];
                }
            }
        }

        // Make 'unique' arrays, so we have TOTAL # played vs. # won
        $totalUniqueTourneyWinners = array_unique($totalTourneyWinners);
        $openUniqueTourneyWinners = array_unique($openTourneyWinners);
        $intermediateUniqueTourneyWinners = array_unique($intermediateTourneyWinners);
        $mainUniqueTourneyWinners = array_unique($mainTourneyWinners);


        // Get counts of rows
        $numGames = count($gameData);
        $numTourneys = count($tourneyData);
        $numUsers = count($userData);
        $numTotalTourneyWinners = count($totalTourneyWinners);
        $numOpenTourneyWinners = count($openTourneyWinners);
        $numIntermediateTourneyWinners = count($intermediateTourneyWinners);
        $numMainTourneyWinners = count($mainTourneyWinners);
        $numUniqueTotalTourneyWinners = count($totalUniqueTourneyWinners);
        $numUniqueOpenTourneyWinners = count($openUniqueTourneyWinners);
        $numUniqueIntermediateTourneyWinners = count($intermediateUniqueTourneyWinners);
        $numUniqueMainTourneyWinners = count($mainUniqueTourneyWinners);

        // Other data 
        $userIndex = $numUsers - 1;
        $mostRecentUser = $userData[$userIndex][0];


    } catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
    }

    ?>

    <body id="resultsDisplayBody">
        <h2>General Information</h2>
        <div id="generalResultsDisplayPanel"> 
            <?php
            echo "<p>Total registered users: $numUsers</p>";
            echo "<p>Most recent user: $mostRecentUser</p>";
            echo "<p>Number of Official Tournaments: $numTourneys</p>";
            echo "<p>Number of game results uploaded: $numGames</p>";
            echo "<p>Total # of titles won: $numTotalTourneyWinners</p>";
            echo "<p># of winners: $numUniqueTotalTourneyWinners</p>";
            echo "<p>Total 'Open' titles won: $numOpenTourneyWinners</p>";
            echo "<p># of winners: $numUniqueOpenTourneyWinners</p>";
            echo "<p>Total 'Intermediate' titles won: $numIntermediateTourneyWinners</p>";
            echo "<p># of winners: $numUniqueIntermediateTourneyWinners</p>";
            echo "<p>Total 'Main' of titles won: $numMainTourneyWinners</p>";
            echo "<p># of winners: $numUniqueMainTourneyWinners</p>";
            ?>
        </div>
    </body>

    
</html>