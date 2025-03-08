<?php
session_start();

include("../admin/db_config.php");

try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // This checks if we have 'all' months selected
    // If not, add a leading 0 to the month so SQL reads it easier
    if ($_GET["month"] == "all") {
        $getMonth = "";
    } else if ($_GET["month"] < 10) {
        $getMonth = "MONTH(tournamentDate)=\"0" . $_GET["month"] . "\" AND ";
    } else {
        $getMonth = "MONTH(tournamentDate)=\"" . $_GET["month"] . "\" AND ";
    }
    // Grab year and division
    $year = $_GET["year"];
    $division = $_GET["division"];

    // Select all the winners from the table where the month, year, and division all match
    $sqlGetTopWinnersList = $conn->prepare("SELECT winner1,winner2,winner3,winner4 FROM " . $tournamentDataTableName . " WHERE $getMonth YEAR(tournamentDate)=\"" . $year . "\" AND tournamentDivision=\"" . $division . "\"");
    $sqlGetTopWinnersList->execute();

    // Fetch the results
    $sqlWinnersList = $sqlGetTopWinnersList->fetchAll(PDO::FETCH_ASSOC);
    $winnersList = array();
    
    foreach ($sqlWinnersList as $winner) {
        for ($i = 1; $i < 4; $i++) {
            if ($winner["winner" . $i] != "N/A") {
                $winnersList[] = $winner["winner" . $i];
            }
        }
    }

    // Array to store names
    $names = array();
    $wins = array();

    $topWinner = array_count_values($winnersList);

    arsort ($topWinner);

    // Break the array-count-values down, because our names became the key and the number of wins is the value
    foreach ($topWinner as $name=>$numWins) {
        $names[] = $name;
        $wins[] = $numWins;
    }

    // Finally we'll display the results below in the proper HTML
    

    for ($i = 0; $i < 10; $i++) {
        // Check if we have any data
        if (isset($names[$i])) {
            $name = $names[$i];
            $numWins = $wins[$i];
        }
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
    <link rel="stylesheet" href="/styles/data.css" />
    <link rel="stylesheet" href="/styles/data_display.css" />
    <script src="/scripts/tools.js"></script>
    <script src="/scripts/results.js"></script>
    <script>verifyPageInFrame()</script>
    <title>GENERAL DATA</title>
</head>

<body id="divisionResultsFrame">
    <div class="divisionResultsTable">
        <?php
        // This latch variable will trigger if we have any data to display
        // If we have nothing to display, we'll tell them that
        $contentLatch = 0;
        for ($i = 0; $i < 10; $i++) {
            // Check if we have any data
            if (isset($names[$i])) {
                $name = $names[$i];
                $numWins = $wins[$i];
                echo "<p class=\"divisionResultsTableLeft\">$name</p>";
                echo "<p class=\"divisionResultsTableRight\">$numWins</p>";
                $contentLatch = 1;
            }
        }
        if ($contentLatch == 0) {
            echo "<p class=\"noContent\">Nothing yet! Check back later!</p>";
        }
        
        
        ?>
    </div>
</body>

</html>