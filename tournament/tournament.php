<?php
session_start();

include("../admin/db_config.php");

try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the division from the page
    $tourneyUID = $_GET["tournamentUID"];

    // If we want all the data, we don't need to select a division in the SQL query
    $sqlGetTourneyInfo = $conn->prepare("SELECT * FROM " . $tournamentDataTableName . " WHERE tournamentUID='" . $tourneyUID . "'");

    $sqlGetTourneyInfo->execute();

} catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
}

$tourneyResults = $sqlGetTourneyInfo->fetch(PDO::FETCH_ASSOC);

$tourneyExists = false;
if (isset($tourneyResults)) {
    if (mb_strtolower($_GET["tournamentUID"]) == mb_strtolower($tourneyResults["tournamentUID"])) {
        $tourneyExists = true;
    }
}
?>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="/styles/primary.css" />
  <link rel="stylesheet" href="/styles/db_management.css" />
  <link rel="stylesheet" href="/styles/tourney_display.css" />
  <script src="/scripts/tools.js"></script>
  <script>//verifyPageInFrame()</script>
  <title>Tournament Details</title>
</head>

<body id="body">
    <script>getURL();</script>
        <div id="contentFrame">
        <img src="/assets/rl_logo_background.svg" alt="Rocket League logo for background" class="backgroundImage">
            <div class="header">
                <div id="headerLeft">
                    <img src="/assets/trojan_image_1.png" alt="Trojan Destiny logo" id="headerImage">
                </div>
                <div id="headerCentre">
                <h1 id="headerText"><a href="/" class="plainLinkBlue">TrojanDestinyRL</a></h1>
                    <div id="youtubeImage" onclick="redirect('this', 'https://www.youtube.com/@TrojanDestinyRL')"><img src="/assets/youtube.svg" alt="youtube logo"></div>
                    <div id="twitchImage" onclick="redirect('this', 'https://www.twitch.tv/trojandestinyrl')"><img src="/assets/twitch.svg" alt="twitch logo"></div>
                    <div id="discordImage" onclick="redirect('this', 'https://discord.gg/bzU5fVxCZJ')"><img src="/assets/discord.svg" alt="discord logo"></div>
                </div>
                <div id="headerRight">
                <img src="/assets/trojan_image_2.png" alt="Trojan Destiny logo" id="headerImage">
                </div>
            </div>
            <p></p>
            <h1>Tournament Information</h1>
            <p class="newLine"></p>
            <div id="tournamentDisplayPanel">
                <?php
                if ($tourneyExists) {
                    $tourneyName = $tourneyResults["tournamentName"];
                    $tourneyDate = $tourneyResults["tournamentDate"];
                    $division = ucfirst($tourneyResults["tournamentDivision"]);
                    $numPlayers = $tourneyResults["numPlayers"];
                    $bestOf = $tourneyResults["bestOf"];
                    $winningTeamName = $tourneyResults["winningTeamName"];
                    $winner1 = $tourneyResults["winner1"];
                    $winner2 = $tourneyResults["winner2"];
                    $winner3 = $tourneyResults["winner3"];
                    $winner4 = $tourneyResults["winner4"];
                    $notes = $tourneyResults["notes"];
                    // Format date
                    $tourneyDate = DateTime::createFromFormat('Y-m-d', $tourneyDate);
                    $tourneyDate = $tourneyDate->format('M j, Y');
                    echo "<div class=\"tournamentDisplay\">";
                    echo "<h3>Details</h2>";
                    echo "<hr class=\"regularLine\">";
                    echo "<h2>$tourneyName</h2>";
                    echo "<p>&nbsp;</p>";
                    echo "<h3>$division Division</h2>";
                    echo "<h4>" . $numPlayers . "v" . $numPlayers . " &mdash; Best of <b>$bestOf</b></h4>";
                    echo "<h4>$tourneyDate</h4>";
                    echo "<hr class=\"halfLine\">";
                    echo "<h3 class=\"underlined\">Winning Team</h3>";
                    echo "<h4 class=\"largerText\">$winningTeamName</h4>";
                    echo "<p>&nbsp;</p>";
                    echo "<p class=\"largerText\"><a href=\"/user/$winner1\" class=\"plainLinkBlack\">$winner1</a></p>";
                    if ($numPlayers >= 2) {
                        echo "<p class=\"largerText\"><a href=\"/user/$winner2\" class=\"plainLinkBlack\">$winner2</a></p>";
                    }
                    if ($numPlayers >= 3) {
                        echo "<p class=\"largerText\"><a href=\"/user/$winner3\" class=\"plainLinkBlack\">$winner3</a></p>";
                    }
                    if ($numPlayers == 4) {
                        echo "<p class=\"largerText\"><a href=\"/user/$winner4\" class=\"plainLinkBlack\">$winner4</a></p>";
                    }
                    echo "<p>&nbsp;</p>";
                    echo "<p>&nbsp;</p>";
                    if ($notes != "" || $notes != NULL) {
                        echo "<h4>Notes:</h4>";
                        echo "<p style=\"width:70%;\">$notes</p>";
                    }
                    echo "</div>";

                    echo "<div class=\"gameDisplay\">";
                    echo "<h3>Games</h3>";
                    echo "<hr class=\"regularLine\">";
                    echo "<p style=\"text-align:center;font-style:italic;color:rgba(100, 100, 100, 0.9);\">Coming soon!</p>";


                } else {
                    echo "<div class=\"noTourney\">";
                    echo "<hr class=\"regularLine\">";
                    echo "<h1>TOURNAMENT NOT FOUND</h1>";
                    echo "</div>";
                }
                ?>
            </div>
            </div>
            <p class="newLine"></p>
            <?php include_once('../display/subnav.php'); ?>
        </div>
</body>


</html>