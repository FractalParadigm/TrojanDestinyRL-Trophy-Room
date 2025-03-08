function refreshDisplay() {
    var divisionButtons = document.getElementsByName("division");
    var currentDivision = "";

    for (var i = 0; i < divisionButtons.length; i++) {
        if (divisionButtons[i].checked) {
            currentDivision = divisionButtons[i].value;
        }
    }

    var displayDiv = document.getElementById("divisionDisplay");

    document.getElementById("divisionDisplay").innerHTML = currentDivision;
    console.log(currentDivision);

    var html = "";
    var image = ""; //get trophy image
    html += "<div class=\"divisionPanel\">";

    // Based on the selected division, show some results
    if (currentDivision == "open") {
        image = "/assets/trophy_open.png";
        html += "<h2><img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:left;\">Open<img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:right;\"></h2>";
    } else if (currentDivision == "intermediate") {
        image = "/assets/trophy_intermediate.png";
        html += "<h2><img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:left;\">Intermediate<img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:right;\"></h2>";
    } else if (currentDivision == "main") {
        image = "/assets/trophy_main.png";
        html += "<h2><img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:left;\">Main<img src=" + image + " class=\"lineImage\" alt=\"" + currentDivision + " division trophy\" style=\"float:right;\"></h2>";
    }
    html += "<p>Top 10 Winners</p>"
    html += "<hr class=\"tableLineLightCentre\">";


    html += "<iframe src=\"/display/division_results.php?division=" + currentDivision + "&month=" + document.getElementById("month").value + "&year=" + document.getElementById("year").value + "\" name=\"divisionFrame\" class=\"divisionFrame\" id=\"divisionFrame\" onload=\"resizeIframe(this);\"></iframe>";

    html += "</div>";
    // TODO;

    // CREATE OUTPUT DISPLAY

    
    document.getElementById("divisionDisplay").innerHTML = html;
}