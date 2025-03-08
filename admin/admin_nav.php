<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="/styles/primary.css" />
        <link rel="stylesheet" href="/styles/admin.css" />
        <link rel="stylesheet" href="/styles/admin_nav.css" />
        <script src="/scripts/tools.js"></script>
        <script>verifyPageInFrame()</script>
        <title>TROJAN'S GENERAL DATA SHIT</title>
    </head>

    <body id="generalBody">
        <div id="informationContentPanel">
            <h3>USER MANAGEMENT</h3>
            <div class="navPanel" id="userManagementPanel">
                <a href="user_management/user_form.php" target="dataFrame" class="navLink">CREATE USER</a>
                <a href="user_management/create_safe_admin.php" target="dataFrame" class="navLink">CREATE PERMA-ADMIN</a>
            </div>
            <p>&nbsp;</p>
            <h3>DATA MANAGEMENT</h3>
            <div class="navPanel" id="tourneyManagementPanel">
                <a href="data_management/game_form.php" target="dataFrame" class="navLink">ADD GAME</a>
                <a href="data_management/tourney_form.php" target="dataFrame" class="navLink">ADD TOURNAMENT</a>
            </div>
            <p>&nbsp;</p>
            <h3>!!!!! DANGER ZONE !!!!!</h3>
            <div class="navPanel" id="dbManagementPanel">
                <a href="db_management/conn_check.php" target="dataFrame" class="navLink">CHECK DB CONNECTION</a>
                <a href="db_management/reinitialise.php" target="dataFrame" class="navLink">REINITIALISE DB</a>
            </div>
            <p>&nbsp;</p>
        </div>
    </body>
</html>