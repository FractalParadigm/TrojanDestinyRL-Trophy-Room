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
        <script>
            // When the device is rotated, automatically refresh the frame
            screen.orientation.addEventListener("change", (event) => {
                document.getElementById("dataFrame").contentWindow.location.reload();
            });
        </script>
    </head>

    <body id="body">
        <div id="contentFrame">
            <img src="/assets/rl_logo_background.svg" alt="Rocket League logo for background" class="backgroundImage">
            <?php include_once('./display/header.html'); ?>
            <h1>Trojan's Trophy Room</h1>
            <h4 style="font-size:150%;margin:auto;"><a href="/giveaway" id="giveawayLink">Giveaway Disclaimer</a></h4>
            <iframe src="/display/general_results.php" name="dataFrame" class="dataFrame" id="dataFrame" onload="resizeIframe(this);"></iframe>
            <p class="newLine"></p>
            <p class="newLine"></p>
            <?php include_once('./display/subnav.php'); ?>
        </div>
    </body>
</html>