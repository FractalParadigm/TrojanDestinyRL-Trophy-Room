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
        html += "<p class=\"smallerText\">Max Rank: SSL</p>"
    } else if (currentDivision == "intermediate") {
        image = "/assets/trophy_intermediate.png";
        html += "<h2><img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:left;\">Intermediate<img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:right;\"></h2>";
        html += "<p class=\"smallerText\">Max Rank: Champ 3</p>"
    } else if (currentDivision == "main") {
        image = "/assets/trophy_main.png";
        html += "<h2><img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:left;\">Main<img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:right;\"></h2>";
        html += "<p class=\"smallerText\">Max Rank: Plat 3</p>"
    }
    html += "<p>Top 10 Winners</p>"
    html += "<hr class=\"tableLineLightCentre\">";


    html += "<iframe src=\"/display/division_results.php?division=" + currentDivision + "&month=" + document.getElementById("month").value + "&year=" + document.getElementById("year").value + "\" name=\"divisionFrame\" class=\"divisionFrame\" id=\"divisionFrame\" onload=\"resizeIframe(this);\"></iframe>";

    html += "</div>";
    // TODO;

    // CREATE OUTPUT DISPLAY

    
    document.getElementById("divisionDisplay").innerHTML = html;
}