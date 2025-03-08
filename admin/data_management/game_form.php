<?php 
session_start();

include("../db_config.php"); // Include database stuff

try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Grab the list of users from the user list
  // We will also grab all the people that have been registered/won before
  $sqlGetUserData = $conn->prepare("SELECT username FROM " . $userTableName . "");
  $sqlGetTourneyData = $conn->prepare("SELECT tournamentName,winner1,winner2,winner3,winner4 FROM " . $tournamentDataTableName . "");

  // Execute SQL query
  $sqlGetUserData->execute();
  $sqlGetTourneyData->execute();

  // Get results from the USERS table
  $results = $sqlGetUserData->fetchAll(PDO::FETCH_ASSOC);

  // Create new arrays to store values
  $userList = array();
  $tourneyList = array();
  
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
    $tourneyList[] = $result["tournamentName"];
  }

  // Remove duplicate entries
  $userList = array_unique($userList);

  // Sort the array to alphabetical order
  sort($userList);


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
        <link rel="stylesheet" href="/styles/game_management.css" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
        <script src="/scripts/game_management.js"></script>
        <script src="/scripts/tools.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
        <title>GAME ADDING FORM</title>
        <script>
        $( function() {
            var userList = <?php echo json_encode($userList); ?>;

            $(".playerInput").autocomplete({
                source: userList,
            });
        } );
        $( function() {
            var tournamentList = <?php echo json_encode($tourneyList); ?>;
            $("#tourneyName").autocomplete({
                source: tournamentList,
                // Change the direction of the autoselector if it's gonna hit the bottom
                position: {
                    collision: "flip"
                },
                // This only allows listed items to be chosen
                change: function (event, ui) {
                    if(!ui.item) {
                        $("#tourneyName").val("");
                    }
                }
            });
        } );
        </script>
    </head>

    <body id="generalBody">
        <div id="gameFormPanel">
            <form id="userForm" action="add_game.php" method="POST" autocomplete="off">
            <h2>ADD GAME RESULTS</h2>
            <p>Add a recently-played game and save the results!</p>
            <hr>
            <p></p>
                <div id="textInputArea">
                    <label for="gameName">Game name</label>
                    <input type="text" id="gameName" name="gameName" maxlength="100" tabindex="1" required>
                    <p class="newLine"></p>
                    <label for="gameName">Game date</label>
                    <input type="date" id="gameDate" name="gameDate"  max="<?php echo date("Y-m-d"); ?>" tabindex="1" required>
                    <p class="newLine"></p>
                </div>
                <div class="optionsArea">
                    <label for="numPlayers">Players:</label>
                    <select id="numPlayers" name="numPlayers" tabindex="1" onchange="addPlayers()">
                        <option value="1">1v1</option>
                        <option value="2" selected="selected">2v2</option>
                        <option value="3">3v3</option>
                        <option value="4">4v4</option>
                    </select>
                    <label for="winners" class="showTeamSelector">Winning team:</label>
                    <select id="winners" name="winners" class="showTeamSelector" tabindex="1">
                        <option value="blue">Blue</option>
                        <option value="orange">Orange</option>
                    </select>
                </div>
                <p class="newLine"></p>
                <div id="playerDataInputArea">
                    <table id="playerData">
                    </table>
                    <script>addPlayers();</script>
                    <p class="newLine"></p>
                </div>
                <p class="newLine"></p>
                <div class="optionsArea">
                    <p class="newLine">If this game was part of a tournament, select it below</p>
                    <input type="text" name="tourneyName" id="tourneyName" maxlength="150" tabindex="4">
                    <p class="newLine">If you have uploaded a replay of this game to <a href="#" onclick="redirect('ballchasing', 'https://ballchasing.com')" class="plainLinkBlue">ballchasing.com</a>, enter the ID code below.</p>
                    <input type="text" name="ballchasingID" id="ballchasingID" maxlength="50" tabindex="4">
                    <p class="newLine"></p>
                    <p>If you have any notes about the game, leave them below</p>
                    <textarea name="notes" id="notes" tabindex="4"></textarea>
                </div>

                <p class="newLine"></p>


                <div id="submitButtonDiv">
                    <p class="newLine"></p> 
                    <input type="submit" value="Submit" id="submitButton"  tabindex="4">
                </div>
                <p class="newLine"></p>
            </form>
        </div>
    </body>

</html>