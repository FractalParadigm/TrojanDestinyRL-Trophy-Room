<?php
session_start();

include("../admin/db_config.php");

try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the division from the page
    $division = $_GET["division"];

    // If we want all the data, we don't need to select a division in the SQL query
    if ($division == "all") {
        $sqlGetTourneyInfo = $conn->prepare("SELECT tournamentName,tournamentDate,tournamentDivision,numPlayers,winningTeamName,winner1,winner2,winner3,winner4 FROM " . $tournamentDataTableName . " ORDER BY tournamentDate DESC LIMIT $tourneyCardLimit");
    } else {
        $sqlGetTourneyInfo = $conn->prepare("SELECT tournamentName,tournamentDate,tournamentDivision,numPlayers,winningTeamName,winner1,winner2,winner3,winner4 FROM " . $tournamentDataTableName . " WHERE tournamentDivision='" . $division . "' ORDER BY tournamentDate DESC LIMIT $tourneyCardLimit");
    }

    $sqlGetTourneyInfo->execute();

} catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
}

$tourneyResults = $sqlGetTourneyInfo->fetchAll(PDO::FETCH_ASSOC);

?>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="/styles/primary.css" />
  <link rel="stylesheet" href="/styles/db_management.css" />
  <link rel="stylesheet" href="/styles/tourney_results.css" />
  <script src="/scripts/tools.js"></script>
  <script>verifyPageInFrame()</script>
  <title>no title</title>
</head>

<body>
    <div class="recentTourneyResultsPanel">
        <?php
            foreach ($tourneyResults as $result) {
                $tourneyName = $result["tournamentName"];
                $tourneyDate = $result["tournamentDate"];
                $division = $result["tournamentDivision"];
                $numPlayers = $result["numPlayers"];
                $winningTeamName = $result["winningTeamName"];
                $winner1 = $result["winner1"];
                $winner2 = $result["winner2"];
                $winner3 = $result["winner3"];
                $winner4 = $result["winner4"];
                // Format date
                $tourneyDate = DateTime::createFromFormat('Y-m-d', $tourneyDate);
                $tourneyDate = $tourneyDate->format('M j, Y');
                echo ("
                <div class=\"tourneyCard\">
                    <p class=\"tourneyCardHeader\">$tourneyName</p>
                    <p class=\"newLineThin\"></p>
                    <p class=\"tourneyCardLeft\">$tourneyDate</p>
                    <p class=\"tourneyCardRight underlined\">$winningTeamName</p>
                    <p class=\"newLineThin\"></p>
                    <p class=\"tourneyCardLeft\">$division</p>
                    <p class=\"tourneyCardRight\"><a href=\"/user/$winner1\" class=\"plainLinkBlack\" onclick=\"redirect('this', '/user/$winner1');\">$winner1</a></p>
                    <p class=\"newLineThin\"></p>
                    <p class=\"tourneyCardLeft\">" . $numPlayers . "v" . $numPlayers . "</p>");
                if ($numPlayers >= 2) {
                    echo "<p class=\"tourneyCardRight\"><a href=\"/user/$winner2\" class=\"plainLinkBlack\" onclick=\"redirect('this', '/user/$winner2');\">$winner2</a></p>";
                }
                echo "<p class=\"newLineThin\"></p>";
                if ($numPlayers >= 3) {
                    echo ("
                    <p class=\"tourneyCardLeft\"></p>
                    <p class=\"tourneyCardRight\"><a href=\"/user/$winner3\" class=\"plainLinkBlack\" onclick=\"redirect('this', '/user/$winner3');\">$winner3</a></p>
                    <p class=\"newLineThin\"></p>");
                }
                if ($numPlayers == 4) {
                    echo ("
                    <p class=\"tourneyCardLeft\"></p>
                    <p class=\"tourneyCardRight\"><a href=\"/user/$winner4\" class=\"plainLinkBlack\" onclick=\"redirect('this', '/user/$winner4');\">$winner4</a></p>
                    <p class=\"newLineThin\"></p>");
                }
                echo ("</div>
                <p class=\"newLineThin\">&nbsp;</p>
                ");
            }
        ?>
    </div>
</body>


</html>