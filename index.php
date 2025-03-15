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
            <div class="header">
                <div id="headerLeft">
                    <img src="/assets/trojan_image_1.png" alt="Trojan Destiny logo" id="headerImage">
                </div>
                <div id="headerCentre">
                    <h1 id="headerText"><a href="/" class="plainLinkBlue">TrojanDestinyRL</a></h1>
                    <div id="youtubeImage" onclick="redirect('mainpage', 'https://www.youtube.com/@TrojanDestinyRL')"><img src="/assets/youtube.svg" alt="youtube logo"></div>
                    <div id="twitchImage" onclick="redirect('mainpage', 'https://www.twitch.tv/trojandestinyrl')"><img src="/assets/twitch.svg" alt="twitch logo"></div>
                    <div id="discordImage" onclick="redirect('mainpage', 'https://discord.gg/bzU5fVxCZJ')"><img src="/assets/discord.svg" alt="discord logo"></div>
                </div>
                <div id="headerRight">
                <img src="/assets/trojan_image_2.png" alt="Trojan Destiny logo" id="headerImage">
                </div>
            </div>
            <p></p>
            <h1>Trojan's Trophy Room</h1>
            <h4 style="font-size:150%;margin:auto;"><a href="/giveaway" id="giveawayLink">Giveaway Disclaimer</a></h4>
            <iframe src="/display/general_results.php" name="dataFrame" class="dataFrame" id="dataFrame" onload="resizeIframe(this);"></iframe>
            <p class="newLine"></p>
            <p class="newLine"></p>
            <div class="subNav">
                <?php 
                // Is the user is logged in we'll show them a navigation bar with some fancier options
                if (isset($_SESSION["userID"])){
                    echo "<a href=\"/user/" . $_SESSION["username"] . " \" class=\"subNavLink\">ACCOUNT</a>";
                    echo "<a href=\"/ \" class=\"subNavLink\">HOME</a>";
                    echo "<a href=\"/user/logout.php \" class=\"subNavLink\">LOGOUT</a>";
                    echo "<a href=\"/admin/data_management/game_form.php \" target=\"dataFrame\" class=\"subNavLink disabled\">ADD GAME DETAILS</a>";
                    // Anything we need to show to logged in admins will be below
                    if (isset($_SESSION["privileges"]) && $_SESSION["privileges"] == 1){
                        echo "<a href=\"/admin/data_management/tourney_form.php \" target=\"dataFrame\" class=\"subNavLink\">ADD A TOURNEY</a>";
                        echo "<a href=\"/admin \" class=\"subNavLink\">ADMIN PANEL</a>";
                    }
                } else {
                    echo "<a href=\"/user/login_page.php \" target=\"dataFrame\" class=\"subNavLink\">SIGN IN</a>";
                    echo "<a href=\"/user/create_account.php \" target=\"dataFrame\" class=\"subNavLink\">CREATE AN ACCOUNT</a>";
                    echo "<a href=\"/ \" class=\"subNavLink\">HOME</a>";
                }
                ?>
            </div>
        </div>
    </body>
</html>