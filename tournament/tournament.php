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
            <div id="tournamentDisplay">
                <?php
                if ($tourneyExists) {
                    $tourneyName = $tourneyResults["tournamentName"];
                    $tourneyDate = $tourneyResults["tournamentDate"];
                    $division = ucfirst($tourneyResults["tournamentDivision"]);
                    $numPlayers = $tourneyResults["numPlayers"];
                    $winningTeamName = $tourneyResults["winningTeamName"];
                    $winner1 = $tourneyResults["winner1"];
                    $winner2 = $tourneyResults["winner2"];
                    $winner3 = $tourneyResults["winner3"];
                    $winner4 = $tourneyResults["winner4"];
                    // Format date
                    $tourneyDate = DateTime::createFromFormat('Y-m-d', $tourneyDate);
                    $tourneyDate = $tourneyDate->format('M j, Y');
                    
                    echo ("THIS TOURNAMENT EXISTS - DETAILS COMING");
                } else {
                    echo "<div class=\"noUser\">";
                    echo "<h2>TOURNAMENT NOT FOUND!</h2>";
                    echo "<p>Double-check your link.</p>";
                    echo "<p>Sorry!</p>";
                    echo "<p>&nbsp;</p>";
                    echo "</div>";
                }
                ?>
            </div>
            <p></p>
            <div class="subNav">
                <?php
                if (isset($_SESSION["privileges"]) && $_SESSION["privileges"] == 1) {
                    echo "<a href=\"/admin/\" class=\"subNavLink\" id=\"adminHomeButton\">ADMIN PANEL</a>";
                }
                ?>
                <a href="../" class="subNavLink" id="mainHomeButton">HOME</a>

                <?php
                // If we're showing someone other than who's logged in, offer a link to their own page
                if (isset($_SESSION["userID"])){
                echo "<a href=\"/user/" . $_SESSION["username"] . " \" class=\"subNavLink\">MY ACCOUNT</a>";
                }
                ?>

                <p class="newLine"></p>
                <?php 
                // If someone is logged in, give them the opportunity to log out
                if (isset($_SESSION["userID"])){
                    echo "<a href=\"../user/logout.php?redirect=\" class=\"subNavLink\" id=\"loginButton\">LOGOUT</a>";
                } else {
                    echo "<a href=\"/user/login_page.php \" target=\"dataFrame\" class=\"subNavLink\">SIGN IN</a>";
                    echo "<a href=\"/create_account.php \" target=\"dataFrame\" class=\"subNavLink\">CREATE AN ACCOUNT</a>";
                    echo "<a href=\"/ \" class=\"subNavLink\">HOME</a>";
                }
                ?>
            </div>
        </div>
</body>


</html>