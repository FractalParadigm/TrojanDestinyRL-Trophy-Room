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
        <?php include ("../db_config.php");?> <!-- Our password-length variable is stored here -->
        <link rel="stylesheet" href="../../styles/primary.css" />
        <link rel="stylesheet" href="../../styles/admin.css" />
        <link rel="stylesheet" href="../../styles/admin_nav.css" />
        <link rel="stylesheet" href="../../styles/game_management.css" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
        <script src="../../scripts/game_management.js"></script>
        <script src="../../scripts/trojan.js"></script>
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
            var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
            var tournamentList = <?php echo json_encode($tourneyList); ?>;
            $("#tourneyName").autocomplete({
                source: tournamentList,
                position: {
                    collision: "flip"
                },
                // This change is supposed to only allow listed items to be chosen
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
                    <p>If this game was part of a tournament, enter the name of it below</p>
                    <input type="text" name="tourneyName" id="tourneyName" maxlength="150" tabindex="4">
                    <p>If you have uploaded a replay of this game to <a href="https://ballchasing.com">ballchasing.com</a>, enter the ID code below.</p>
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