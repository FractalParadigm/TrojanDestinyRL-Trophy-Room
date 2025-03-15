<?php 
session_start();

include("../admin/db_config.php"); // Include database stuff

try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tourneyID = $_GET["tournamentID"];

    // Grab the list of users from the user list
    // We will also grab all the people that have been registered/won before
    $sqlGetUserData = $conn->prepare("SELECT username FROM " . $userTableName . "");
    $sqlGetTourneyData = $conn->prepare("SELECT winner1,winner2,winner3,winner4 FROM " . $tournamentDataTableName . "");
    $sqlGetAllTourneyData = $conn->prepare("SELECT * FROM " . $tournamentDataTableName . " WHERE tournamentID='" . $tourneyID . "'");

    // Execute SQL query
    $sqlGetUserData->execute();
    $sqlGetTourneyData->execute();
    $sqlGetAllTourneyData->execute();

    // Get results from the USERS table
    $results = $sqlGetUserData->fetchAll(PDO::FETCH_ASSOC);

    // Create array to store values
    $userList = array();
    
    // Move results to their own array, easier to convert for Javascript
    foreach ($results as $result) {
        $userList[] = $result["username"];
    }


    // Get results from the TOURNEY table
    $results = $sqlGetTourneyData->fetchAll(PDO::FETCH_ASSOC);
    
    // Move results to their own array, easier to convert for Javascript
    foreach ($results as $result) {
        $userList[] = $result["winner1"];
        $userList[] = $result["winner2"];
        $userList[] = $result["winner3"];
        $userList[] = $result["winner4"];
    }

    // Make sure we only have each name once
    $userList = array_unique($userList);
    // Sort the array to alphabetical order
    sort($userList);

    $tourneyResults = $sqlGetAllTourneyData->fetch(PDO::FETCH_ASSOC);

    // Grab tournament info
    // Set variables from SQL data
    $tourneyName = $tourneyResults["tournamentName"];
    $tourneyUID = $tourneyResults["tournamentUID"];
    $tourneyDate = $tourneyResults["tournamentDate"];
    $division = $tourneyResults["tournamentDivision"];
    $numPlayers = $tourneyResults["numPlayers"];
    $bestOf = $tourneyResults["bestOf"];
    $winningTeamName = $tourneyResults["winningTeamName"];
    $winner1 = $tourneyResults["winner1"];
    $winner2 = $tourneyResults["winner2"];
    $winner3 = $tourneyResults["winner3"];
    $winner4 = $tourneyResults["winner4"];
    $notes = $tourneyResults["notes"];


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
        <link rel="stylesheet" href="/styles/admin.css" />
        <link rel="stylesheet" href="/styles/admin_nav.css" />
        <link rel="stylesheet" href="/styles/tourney_management.css" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
        <script src="/scripts/tourney_management.js"></script>
        <script src="/scripts/tools.js"></script>
        <script>//verifyPageInFrame()</script>
        <script>
            if (parent.window.screen.width >= 360 && window.screen.width <= 1024) {
                // If mobile, get the mobile version
                window.location.replace("/tournament/edit_mobile.php");
            }
        </script>
        <title>TOURNAMENT EDITING FORM</title>
        <script>
        $( function() {
            var userList = <?php echo json_encode($userList); ?>;

            $(".playerInput").autocomplete({
                source: userList,
            });
        } );
        </script>
    </head>

    <body id="body">
        <div id="contentFrame">
        <img src="/assets/rl_logo_background.svg" alt="Rocket League logo for background" class="backgroundImage">
        <?php include_once('../display/header.html'); ?>
        <div id="tourneyFormPanel">
            <form id="userForm" action="/admin/data_management/edit_tourney.php" method="POST" autocomplete="off">
            <h2>EDIT TOURNAMENT</h2>
            <hr>
            <p></p>
                <div id="textInputArea">
                    <label for="tourneyName">Tournament name</label>
                    <input type="text" id="tourneyName" name="tourneyName" value="<?php echo $tourneyName; ?>" maxlength="150" tabindex="1" required>
                    <p class="newLine"></p>
                    <label for="tourneyName">Tournament date</label>
                    <input type="date" id="tourneyDate" name="tourneyDate"  max="<?php echo date("Y-m-d"); ?>" value="<?php echo $tourneyDate; ?>" tabindex="1" required>
                    <p class="newLine"></p>
                </div>
                <div class="optionsArea">
                    <label for="division">Division:</label>
                    <select id="division" name="division" tabindex="1">
                        <option value="main">Main</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="open">Open</option>
                    </select>
                    <script>selectElement('division', '<?php echo $division; ?>');</script>
                    <p class="newLine"></p>
                    <label for="numPlayers">Players:</label>
                    <select id="numPlayers" name="numPlayers" tabindex="1" onchange="changePlayers()">
                        <option value="1">1v1</option>
                        <option value="2">2v2</option>
                        <option value="3">3v3</option>
                        <option value="4">4v4</option>
                    </select>
                    <script>selectElement('numPlayers', '<?php echo $numPlayers; ?>');</script>
                    <label for="bestOf">Best of:</label>
                    <select id="bestOf" name="bestOf" tabindex="1">
                        <option value="1">1</option>
                        <option value="3">3</option>
                        <option value="5">5</option>
                        <option value="7">7</option>
                    </select>
                    <script>selectElement('bestOf', '<?php echo $bestOf; ?>');</script>
                </div>
                <p class="newLine"></p>
                <div id="playerDataInputArea"> 
                    <p id="teamNameHeader">WINNING TEAM NAME:</p>
                    <input type="text" name="winningTeamName" class="teamInput" maxlength="30" value="<?php echo $winningTeamName; ?>" tabindex="1">
                    <h4>Roster</h4>
                    <table id="playerData">
                    </table>
                    <script>addPlayers();</script>
                    <script>
                        var winner1 = <?php echo json_encode($winner1, JSON_HEX_TAG); ?>;
                        var winner2 = <?php echo json_encode($winner2, JSON_HEX_TAG); ?>;
                        var winner3 = <?php echo json_encode($winner3, JSON_HEX_TAG); ?>;
                        var winner4 = <?php echo json_encode($winner4, JSON_HEX_TAG); ?>;
                        document.getElementById("1").value = winner1;
                        document.getElementById("2").value = winner2;
                        document.getElementById("3").value = winner3;
                        document.getElementById("4").value = winner4;
                    </script>
                    <p class="newLine"></p>
                </div>
                <p class="newLine"></p>
                <div class="optionsArea">
                    <p class="newLine"></p>
                    <p class="newLine">Notes</p>
                    <textarea name="notes" id="notes" tabindex="4"><?php echo $notes; ?></textarea>
                    <p class="newLine"></p>
                    <input type="hidden" id="tourneyID" name="tourneyID" value="<?php echo $tourneyID; ?>">
                    <input type="hidden" id="tourneyUID" name="tourneyUID" value="<?php echo $tourneyUID; ?>">
                </div>
                <p class="newLine"></p>
                <div id="submitButtonDiv">
                    <p class="newLine"></p> 
                    <input type="submit" value="Save" id="submitButton"  tabindex="4">
                </div>
                <p class="newLine"></p>
            </form>
        </div>
        <?php include_once('../display/subnav.php'); ?>
        </div>
    </body>

</html>