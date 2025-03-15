<?php 
include("../db_config.php"); // Include database

/*
function getIDfromName($name) {
    $key = array_search('Test Tourney V6 EDIT', array_column($tourneyIndex, 'name'));
    echo ($tourneyIndex[$key]['id']) . " - ";
    echo ($tourneyIndex[$key]['name']);
}*/
?>


<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="/styles/primary.css" />
        <link rel="stylesheet" href="/styles/admin.css" />
        <link rel="stylesheet" href="/styles/admin_nav.css" />
        <link rel="stylesheet" href="/styles/tourney_management.css" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
        <script src="/scripts/tourney_management.js"></script>
        <script src="/scripts/tools.js"></script>
        <script>verifyPageInFrame()</script>
        <title>TOURNEY EDITING FORM</title>
    </head>

    <body id="generalBody">
        <div id="tourneyEditPanel">
            <h2>TOURNEY EDITING</h2>
            <p>Edit tournaments here</p>
            <hr>
            <p></p>

            <div class="tourneyListPanel">
                <p class="tournamentIDCol"><b>ID</b></p>
                <p class="tournamentNameCol"><b>Name</b></p>
                <p class="editTournamentCol">&nbsp;</p>
                <p class="deleteTournamentCol">&nbsp;</p>
                <p class="newLineThin"></p>
                <?php


                try {  // Try opening the SQL database connection
                $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Grab the list of users from the user list
                $sqlGetUserData = $conn->prepare("SELECT tournamentID,tournamentUID,tournamentName FROM " . $tournamentDataTableName . " ORDER BY tournamentID DESC");
                

                // Execute SQL query
                $sqlGetUserData->execute();

                // Get results from the USERS table
                $results = $sqlGetUserData->fetchAll(PDO::FETCH_ASSOC);
                

                } catch (PDOException $e) { // failed connection
                    echo "Connection failed: " . $e->getMessage();
                }


                foreach ($results as $result) {
                    $tournamentID = $result["tournamentID"];
                    $tournamentUID = $result["tournamentUID"];
                    $tournamentName = $result["tournamentName"];

                    echo "<p class=\"tournamentIDCol\">$tournamentID</p>";
                    echo "<p class=\"tournamentNameCol\"><a href=\"/tournament/$tournamentUID\" class=\"plainLinkBlack\" onclick=\"redirect('this', '/tournament/$tournamentUID')\">$tournamentName</a></p>";
                    echo "<p class=\"editTournamentCol\"><a href=\"/tournament/edit?tournamentID=$tournamentID\" class=\"plainLinkBlack\" onclick=\"redirect('this', '/tournament/edit.php?tournamentID=$tournamentID')\">EDIT</a></p>";
                    echo "<p class=\"deleteTournamentCol\">DELETE</p>";
                    echo "<p class=\"newLineThin\"></p>";
                }


                ?>
            </div>

            <div id="tourneyEditFrameDiv">
            
            </div>

            <p>&nbsp;</p>
        </div>
    </body>
</html>