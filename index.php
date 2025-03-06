<?php
session_start();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="/styles/primary.css" />
        <script src="/scripts/tools.js"></script>
        <title>Trojan's Trophy Room</title>
    </head>

    <body id="body">
        <div id="contentFrame">
            <h1>Trojan's Trophy Room</h1>
            <h4><a href="/giveaway" id="giveawayLink">Giveaway Disclaimer</a></h4>
            <h3>Choose a division to see results!</h3>
            <div class="navPanel">
                <a href="/open.html" target="dataFrame" class="navLink">OPEN</a>
                <a href="/intermediate.html" target="dataFrame" class="navLink">INTERMEDIATE</a>
                <a href="/main.html" target="dataFrame" class="navLink">MAIN</a>
                <p class="newLine"></p>
                <a href="/general.html" target="dataFrame" class="navLink">GENERAL (HOME)</a>
            </div>
            <p>&nbsp;</p>
            <iframe src="/open.html" name="dataFrame" class="dataFrame" id="dataFrame" onload="resizeIframe(this);"></iframe>
            <p class="newLine"></p>
            <p class="newLine"></p>
            <div class="subNav">
                <?php 
                // Is the user is logged in we'll show them a navigation bar with some fancier options
                if (isset($_SESSION["userID"])){
                    echo "<a href=\"/user/" . $_SESSION["username"] . " \" class=\"subNavLink\">ACCOUNT</a>";
                    echo "<a href=\"/logout.php \" class=\"subNavLink\">LOGOUT</a>";
                    echo "<a href=\"/admin/data_management/game_form.php \" target=\"dataFrame\" class=\"subNavLink\">ADD GAME DETAILS</a>";
                    // Anything we need to show to logged in admins will be below
                    if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == 1){
                        echo "<a href=\"/admin/data_management/tourney_form.php \" target=\"dataFrame\" class=\"subNavLink\">ADD A TOURNEY</a>";
                        echo "<a href=\"/admin \" class=\"subNavLink\">ADMIN PANEL</a>";
                    }
                } else {
                    echo "<a href=\"/login_page.php \" target=\"dataFrame\" class=\"subNavLink\">SIGN IN</a>";
                    echo "<a href=\"/create_account.php \" target=\"dataFrame\" class=\"subNavLink\">CREATE AN ACCOUNT</a>";
                }
                ?>
            </div>
        </div>
    </body>
</html>