<?php 
session_start();

include("../db_config.php"); // Include database stuff

try {  // Try opening the SQL database connection
  $conn = new PDO("mysql:host=$servername; dbname=$dbName", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Grab the list of users from the user list
  // We will also grab all the people that have been registered/won before
  $sqlGetUserData = $conn->prepare("SELECT username FROM " . $userTableName . "");
  $sqlGetTourneyData = $conn->prepare("SELECT winner1,winner2,winner3,winner4 FROM " . $tournamentDataTableName . "");

  // Execute SQL query
  $sqlGetUserData->execute();
  $sqlGetTourneyData->execute();

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
        <?php include ("../db_config.php");?> <!-- Our password-length variable is stored here -->
        <link rel="stylesheet" href="../../styles/primary.css" />
        <link rel="stylesheet" href="../../styles/admin.css" />
        <link rel="stylesheet" href="../../styles/admin_nav.css" />
        <link rel="stylesheet" href="tourney_management.css" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
        <script src="../../scripts/tourney_management.js"></script>
        <script src="../../scripts/trojan.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
        <title>TOURNAMENT ADDING FORM</title>
        <script>
        $( function() {
            var userList = <?php echo json_encode($userList); ?>;

            $(".playerInput").autocomplete({
                source: userList,
            });
        } );
        </script>
    </head>

    <body id="generalBody">
        <div id="tourneyFormPanel">
            <form id="userForm" action="add_tourney.php" method="POST" autocomplete="off">
            <h2>ADD NEW TOURNAMENT</h2>
            <p>Add a recently-played tournament and record the victors.</p>
            <p>Users will be able to add their own replays and information to the tournaments (later).</p>
            <p>This is also how trophies will be tracked!</p>
            <hr>
            <p></p>
                <div id="textInputArea">
                    <label for="tourneyName">Tournament name</label>
                    <input type="text" id="tourneyName" name="tourneyName" maxlength="150" tabindex="1" required>
                    <p class="newLine"></p>
                    <label for="tourneyName">Tournament date</label>
                    <input type="date" id="tourneyDate" name="tourneyDate"  max="<?php echo date("Y-m-d"); ?>" tabindex="1" required>
                    <p class="newLine"></p>
                </div>
                <div class="optionsArea">
                    <label for="division">Division:</label>
                    <select id="division" name="division" tabindex="1">
                        <option value="main">Main</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="open">Open</option>
                    </select>
                    <p class="newLine"></p>
                    <label for="numPlayers">Players:</label>
                    <select id="numPlayers" name="numPlayers" tabindex="1" onchange="addPlayers()">
                        <option value="1">1v1</option>
                        <option value="2" selected="selected">2v2</option>
                        <option value="3">3v3</option>
                        <option value="4">4v4</option>
                    </select>
                    <label for="bestOf">Best of:</label>
                    <select id="bestOf" name="bestOf" tabindex="1">
                        <option value="1">1</option>
                        <option value="3" selected="selected">3</option>
                        <option value="5">5</option>
                        <option value="7">7</option>
                    </select>
                </div>
                <p class="newLine"></p>
                <div id="playerDataInputArea"> 
                    <p id="teamNameHeader">WINNING TEAM NAME:</p>
                    <input type="text" name="winningTeamName" class="teamInput" maxlength="35" tabindex="1">
                    <h4>Roster</h4>
                    <table id="playerData">
                    </table>
                    <script>addPlayers();</script>
                    <p class="newLine"></p>
                </div>
                <p class="newLine"></p>
                <div class="optionsArea">
                    <p class="newLine"></p>
                    <p>If you have any notes about the tournament, leave them below</p>
                    <textarea name="notes" id="notes" tabindex="4"></textarea>
                    <p class="newLine"></p>
                    <p>Once the tournament is created, users will be able to attribute their games to it through the game creation/editing screen.</p>
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