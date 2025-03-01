<?php
session_start();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="styles/primary.css" />
        <script src="scripts/trojan.js"></script>
        <title>Trojan's Trophy Room</title>
    </head>

    <body id="body">
        <div id="contentFrame">
            <h1>Trojan's Trophy Room</h1>
            <h3>Choose a division to see results!</h3>
            <div id="navPanel">
                <a href="open.html" target="dataFrame" class="navLink">OPEN</a>
                <a href="intermediate.html" target="dataFrame" class="navLink">INTERMEDIATE</a>
                <a href="main.html" target="dataFrame" class="navLink">MAIN</a>
                <p class="newLine"></p>
                <a href="general.html" target="dataFrame" class="navLink">GENERAL (HOME)</a>
            </div>
            <p>&nbsp;</p>
            <iframe src="open.html" name="dataFrame" class="dataFrame" id="dataFrame" onload="resizeIframe(this);"></iframe>
            <p class="newLine"></p>
            <p class="newLine"></p>
            <div id="subNav">
                <?php 
                if (isset($_SESSION["userID"])){
                    echo "<a href=\"logout.php \" class=\"navLink\" id=\"logoutButton\">LOGOUT</a>";
                } else {
                    echo "<a href=\"login_page.php \" target=\"dataFrame\" class=\"navLink\" id=\"loginButton\">SIGN IN</a>";
                }
                ?>
            </div>
        
        
        </div>
        
    </body>
</html>