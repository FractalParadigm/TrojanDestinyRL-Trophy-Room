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
        <script src="/scripts/results.js"></script>
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

        // Initialize array to get dates of tourneys
        $tourneyYears = array();
        $tourneyMonths = array();

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
            // Grab the year from our tourney date
            $tourneyYears[] = date("Y", strtotime($data["tournamentDate"]));
            $tourneyMonths[] = date("n", strtotime($data["tournamentDate"]));
        }

        // Make 'unique' arrays, so we have TOTAL # played vs. # won
        $totalUniqueTourneyWinners = array_unique($totalTourneyWinners);
        $openUniqueTourneyWinners = array_unique($openTourneyWinners);
        $intermediateUniqueTourneyWinners = array_unique($intermediateTourneyWinners);
        $mainUniqueTourneyWinners = array_unique($mainTourneyWinners);

        // Unique-array for tournament years
        $years = array();
        $tourneyYears = array_unique($tourneyYears);
        foreach ($tourneyYears as $year) {
            $years[] = $year;
        }
        sort($years); // Sort the years to put them in order of earliest to latest
        


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
        <div id="generalResultsDisplayPanel"> 
            <h2>General Information</h2>
            <hr class="tableLine">
            <p>&nbsp;</p>
            <div id="generalResultsTable">
                <p class="generalResultsTableLeft">Number of registered users:</p>
                <p class="generalResultsTableRight textBold"><?php echo $numUsers; ?></p>
                <hr class="tableLine">
                <!-- Next line!  -->
                <p class="generalResultsTableLeft">Most recently registered user:</p>
                <p class="tableSpacer"></p>
                <p class="generalResultsTableRight"><a href="/user/<?php echo $mostRecentUser; ?>" class="plainLinkBlack" onclick="redirect('this', '/user/<?php echo $mostRecentUser; ?>')"><?php echo $mostRecentUser; ?></a></p>
                <hr class="tableLine">
                <!-- Next line!  -->
                <p class="generalResultsTableLeft">Number of game results uploaded:</p>
                <p class="tableSpacer"></p>
                <p class="generalResultsTableRight textBold"><?php echo $numGames; ?></p>
                <hr class="tableLine">
                <!-- Next line!  -->
                <p class="generalResultsTableLeft textBold">Number of Official Tournaments:</p>
                <p class="tableSpacer"></p>
                <p class="generalResultsTableRight textBold"><?php echo $numTourneys; ?></p>
                <hr class="tableLineLight">
                <!-- Next line!  -->
                <p class="generalResultsTableLeft">Total # of titles won:</p>
                <p class="tableSpacer"></p>
                <p class="generalResultsTableRight"><?php echo $numTotalTourneyWinners; ?></p>
                <hr class="tableLineLight">
                <!-- Next line!  -->
                <p class="generalResultsTableLeft">Unique winners:</p>
                <p class="tableSpacer"></p>
                <p class="generalResultsTableRight"><?php echo $numUniqueTotalTourneyWinners; ?></p>
                <hr class="tableLine">
                <!-- Next line!  -->
                <p class="generalResultsTableLeft textBold">Total 'Open' titles won:</p>
                <p class="tableSpacer"></p>
                <p class="generalResultsTableRight textBold"><?php echo $numOpenTourneyWinners; ?></p>
                <hr class="tableLineLight">
                <!-- Next line!  -->
                <p class="generalResultsTableLeft">Unique winners:</p>
                <p class="tableSpacer"></p>
                <p class="generalResultsTableRight"><?php echo $numUniqueOpenTourneyWinners; ?></p>
                <hr class="tableLine">
                <!-- Next line!  -->
                <p class="generalResultsTableLeft textBold">Total 'Intermediate' titles won:</p>
                <p class="tableSpacer"></p>
                <p class="generalResultsTableRight textBold"><?php echo $numIntermediateTourneyWinners; ?></p>
                <hr class="tableLineLight">
                <!-- Next line!  -->
                <p class="generalResultsTableLeft">Unique winners:</p>
                <p class="tableSpacer"></p>
                <p class="generalResultsTableRight"><?php echo $numUniqueIntermediateTourneyWinners; ?></p>
                <hr class="tableLine">
                <!-- Next line!  -->
                <p class="generalResultsTableLeft textBold">Total 'Main' titles won:</p>
                <p class="tableSpacer"></p>
                <p class="generalResultsTableRight textBold"><?php echo $numMainTourneyWinners; ?></p>
                <hr class="tableLineLight">
                <!-- Next line!  -->
                <p class="generalResultsTableLeft">Unique winners:</p>
                <p class="tableSpacer"></p>
                <p class="generalResultsTableRight"><?php echo $numUniqueMainTourneyWinners; ?></p>
                <hr class="tableLine">
            </div>
            <p>&nbsp;</p>
        </div>

        <div id="divisionDisplayPanel">
            <h2>Per-Division Results</h2>
            <div class="divisionNavPanel">
                <input type="radio" id="openButton" name="division" value="open" onclick="refreshDisplay();" checked="checked">
                <label for="openButton" id="openButton">Open</label>
                <input type="radio" id="intermediateButton" name="division" value="intermediate" onclick="refreshDisplay();">
                <label for="intermediateButton" id="intermediateButton">Intermediate</label>
                <input type="radio" id="mainButton" name="division" value="main" onclick="refreshDisplay();">
                <label for="mainButton" id="mainButton">Main</label>
            </div>
            <div class="dateSelector">
                <select size="1" name="month" id="month" onchange="refreshDisplay();">
                    <option value="all">All</option> <!-- all option  -->
                    <?php
                    // Automatically write the months using a script
                    // Also automatically selects the current month
                        for ($i = 1; $i <= 12; $i++) {
                            if (date('m', time()) == $i) {
                                $dateObject = DateTime::createFromFormat("!m", $i);
                                echo "<option selected value=\"" . $i . "\">" . $dateObject->format('F') . " </option>";
                            } else {
                                $dateObject = DateTime::createFromFormat("!m", $i);
                                echo "<option value=\"" . $i . "\">" . $dateObject->format('F') . " </option>";
                            }
                        }
                    ?>
                </select>
                <select size="1" name="year" id="year" onchange="refreshDisplay();">
                <option value="all">All</option> <!-- all option  -->
                    <?php
                    // This uses the years we grabbed earlier and ensures we're only showing
                    // the years we have entries for
                        for ($i = 0; $i < count($years); $i++) {
                            if ($i == (count($years) - 1)) {
                                echo "<option selected value=\"" . $years[$i] . "\"> " . $years[$i] . "</option>";
                            } else {
                                echo "<option value=\"" . $years[$i] . "\"> " . $years[$i] . "</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <p> </p>
            <hr class="tableLine">
            <p> </p>
            <div id="divisionDisplay">

            </div>
        </div>
        <script>refreshDisplay(); // Initial division to load</script>
    </body>

    
</html>