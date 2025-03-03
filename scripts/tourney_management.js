function addPlayers(){
    // Get number of players from drop-down on page
    var numberPlayers = document.getElementById("numPlayers").value;
    
    // Grab the table for the input data
    playerDataTable = document.getElementById("playerData");

    playerDataTable.innerHTML = "";  // Clear table
      
    // Create the appropriate number of rows for players, based on the user input
    for (var i = 1; i <= numberPlayers; i++) {
        row = playerDataTable.insertRow(-1);
        var playerNum = row.insertCell(0);
        var playerName = row.insertCell(1);
        playerNum.innerHTML = i + " -";
        playerName.innerHTML = "<input type=\"text\" name=\"winningPlayer" + i + "\" id=\"" + i + "\" class=\"playerInput\" maxlength=\"30\" tabindex=\"3\">";
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