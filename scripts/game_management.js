function addPlayers(){
    // Get number of players from drop-down on page
    var numberPlayers = document.getElementById("numPlayers").value;
    
    // Grab the table for the input data
    playerDataTable = document.getElementById("playerData");

    playerDataTable.innerHTML = "";  // Clear table

    // Create the score row
    var scoreRow = playerDataTable.insertRow(-1);
    var scoreBlue = scoreRow.insertCell(0);
    var scoreHeader = scoreRow.insertCell(1);
    var scoreOrange = scoreRow.insertCell(2);

    scoreRow.id = "scoreRow";

    scoreBlue.innerHTML = "<input type=\"text\" name=\"blueScore\" class=\"scoreInput\" id=\"blueScore\" maxlength=\"3\" oninput=\"checkIfScoreTied()\" tabindex=\"1\" required>";
    scoreHeader.innerHTML = "<p id=\"scoreHeader\">SCORE</p>";
    scoreOrange.innerHTML = "<input type=\"text\" name=\"orangeScore\" class=\"scoreInput\" id=\"orangeScore\" maxlength=\"3\" oninput=\"checkIfScoreTied()\" tabindex=\"1\" required>";

    // Create the header row
    var header = playerDataTable.insertRow(-1);
    var blueHeader = header.insertCell(0);
    var headerSpacer = header.insertCell(1);
    var orangeHeader = header.insertCell(2);

    blueHeader.innerHTML = "<p class=\"tableHeader\">BLUE</p>";
    headerSpacer.innerHTML = "<p id=\"playerTableMiddleSpacer\" class=\"tableHeader\"></p>";
    orangeHeader.innerHTML = "<p class=\"tableHeader\">ORANGE</p>";

    
    // Create the teamname row
    var teamNames = playerDataTable.insertRow(-1);
    hometeamName = teamNames.insertCell(0);
    teamNameHeader = teamNames.insertCell(1);
    awayteamName = teamNames.insertCell(2);

    
    hometeamName.innerHTML = "<input type=\"text\" name=\"blueTeamName\" class=\"teamInput\" maxlength=\"35\" placeholder=\"Blue\" tabindex=\"1\">";
    teamNameHeader.innerHTML = "<p id=\"teamNameHeader\"><pre>TEAM\nNAME</pre></p>";
    awayteamName.innerHTML = "<input type=\"text\" name=\"orangeTeamName\" class=\"teamInput\" maxlength=\"35\" placeholder=\"Orange\" tabindex=\"1\">";


    // Create the subheader
    var subHeader = playerDataTable.insertRow(-1);
    homeSubHeader = subHeader.insertCell(0);
    playerSubHeader = subHeader.insertCell(1);
    awaySubHeader = subHeader.insertCell(2);

    
    homeSubHeader.innerHTML = "<p class=\"tableSubHeader\">HOME</p>";
    playerSubHeader.innerHTML = "<p class=\"tableSubHeader\">PLAYER</p>";
    awaySubHeader.innerHTML = "<p class=\"tableSubHeader\">AWAY</p>";

    // Create the number of rows for players
    for (var i = 1; i <= 4; i++) {
        row = playerDataTable.insertRow(-1);
        var bluePlayer = row.insertCell(0);
        var playerNum = row.insertCell(1);
        var orangePlayer = row.insertCell(2);
        bluePlayer.innerHTML = "<input type=\"text\" name=\"bluePlayer" + i + "\" id=\"bluePlayer" + i + "\" class=\"playerInput\" maxlength=\"30\" tabindex=\"2\">";
        playerNum.innerHTML = "- " + i + " -";
        orangePlayer.innerHTML = "<input type=\"text\" name=\"orangePlayer" + i + "\" id=\"orangePlayer" + i + "\" class=\"playerInput\" maxlength=\"30\" tabindex=\"3\">";
        row.id = "row" + i;
        row.classList.add("hidden");
    }
    for (var i = 1; i <= numberPlayers; i++) {
        document.getElementById("row" + i).classList.remove("hidden");
    }
    
    console.log(userList);

}

function changePlayers() {
    // Changes the number of players displayed

    var numberPlayers = document.getElementById("numPlayers").value;

    for (var i = 1; i <= 4; i++) {
        document.getElementById("row" + i).classList.add("hidden");
    }

    for (var i = 1; i <= numberPlayers; i++) {
        document.getElementById("row" + i).classList.remove("hidden");
    }

}

function checkIfScoreTied() {
    var blueScore = document.getElementById("blueScore").value;
    var orangeScore = document.getElementById("orangeScore").value;

    var optionsToShow = document.getElementsByClassName("showTeamSelector");

    if (!blueScore) {
        blueScore = 0;
    }
    if (!orangeScore) {
        orangeScore = 0;
    }


    if (blueScore == orangeScore) {
        if (blueScore != 0) {
            for (var i = 0; i < optionsToShow.length; i++) {
                optionsToShow[i].style.visibility = "visible";
            }
        }
    } else {
        for (var i = 0; i < optionsToShow.length; i++) {
            optionsToShow[i].style.visibility = "hidden";
        }
    }
}