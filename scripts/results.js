function refreshDisplay() {
    // Grab the division buttons by their name
    var divisionButtons = document.getElementsByName("division");
    var currentDivision = "";

    // Loop through the division buttons and see which one is checked
    // Set the current division to that option
    for (var i = 0; i < divisionButtons.length; i++) {
        if (divisionButtons[i].checked) {
            currentDivision = divisionButtons[i].value;
        }
    }

    // If we set 'years' to all, then we should show all months too. 
    // This is effectively a "show all" setting
    if (document.getElementById("year").value == "all") {
        document.getElementById("month").value = "all";
    }

    // Grab the current division from the page
    document.getElementById("divisionDisplay").innerHTML = currentDivision;
    

    var html = ""; // placeholder for webpage
    var image = ""; //get trophy image
    html += "<div class=\"divisionPanel\">";

    // Based on the selected division, show some results
    if (currentDivision == "open") {
        image = "/assets/trophy_open.png";
        html += "<h2><img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:left;\">Open<img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:right;\"></h2>";
        html += "<p class=\"smallerText\">Max Rank: Plat 3</p>"
    } else if (currentDivision == "intermediate") {
        image = "/assets/trophy_intermediate.png";
        html += "<h2><img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:left;\">Intermediate<img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:right;\"></h2>";
        html += "<p class=\"smallerText\">Max Rank: Champ 3</p>"
    } else if (currentDivision == "main") {
        image = "/assets/trophy_main.png";
        html += "<h2><img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:left;\">Main<img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:right;\"></h2>";
        html += "<p class=\"smallerText\">Max Rank: SSL</p>"
    }
    html += "<p>Top 10 Winners</p>"
    html += "<hr class=\"tableLineLightCentre\">";


    html += "<iframe src=\"/display/division_results.php?division=" + currentDivision + "&month=" + document.getElementById("month").value + "&year=" + document.getElementById("year").value + "\" name=\"divisionFrame\" class=\"divisionFrame\" id=\"divisionFrame\" onload=\"resizeIframe(this);var obj=parent.document.getElementById('dataFrame');resizeIframe(obj);\"></iframe>";

    html += "</div>";
    
    document.getElementById("divisionDisplay").innerHTML = html;
    
}

function toggleInformationDisplay() {
    // Used to swap between 'general information' and 'recent tourney results' on the home page
    var infoDiv = document.getElementById("generalResultsDisplayPanel");
    var tourneyDiv = document.getElementById("tourneyResultsDisplayPanel");

    if (infoDiv.style.display == "block") {
        infoDiv.style.display = "none";
        tourneyDiv.style.display = "block";
    } else if (infoDiv.style.display == "none") {
        infoDiv.style.display = "block";
        tourneyDiv.style.display = "none";
    }
}

function refreshTourneyDisplay() {
    // Used to refresh the data in the iframe on the main page, under the 'recent tourney results'
    // Grab the division buttons by their name
    var divisionButtons = document.getElementsByName("resultsDivision");
    var currentDivision = "";

    
    // Loop through the division buttons and see which one is checked
    // Set the current division to that option
    for (var i = 0; i < divisionButtons.length; i++) {
        if (divisionButtons[i].checked) {
            currentDivision = divisionButtons[i].value;
        }
    }

    // Create variable for easier readability
    var html = "<iframe src=\"/tournament/tourney_cards.php?division=" + currentDivision + "\" name=\"recentTourneyFrame\" class=\"recentTourneyFrame\" id=\"recentTourneyFrame\" onload=\"resizeIframe(this);var obj=parent.document.getElementById('dataFrame');resizeIframe(obj);\"></iframe>";

    document.getElementById("recentTourneyDisplay").innerHTML = html;
}