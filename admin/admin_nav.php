<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="../styles/primary.css" />
        <link rel="stylesheet" href="../styles/admin.css" />
        <link rel="stylesheet" href="../styles/admin_nav.css" />
        <!-- <script src="trojan.js"></script>-->
        <title>TROJAN'S GENERAL DATA SHIT</title>
    </head>

    <body id="generalBody">
        <div id="informationContentPanel">
            <h3>USER MANAGEMENT</h3>
            <div class="navPanel" id="userManagementPanel">
                <a href="user_management/user_form.php" target="dataFrame" class="navLink">CREATE USER</a>
                <a href="#" target="dataFrame" class="navLink">MODIFY USER</a>
                <a href="#" target="dataFrame" class="navLink">SHOW ALL USERS</a>
                <a href="user_management/create_safe_admin.php" target="dataFrame" class="navLink">CREATE SAFE ADMIN</a>
            </div>
            <p>&nbsp;</p>
            <h3>DATA MANAGEMENT</h3>
            <div class="navPanel" id="tourneyManagementPanel">
                <a href="data_management/game_form.php" target="dataFrame" class="navLink">ADD GAME</a>
                <a href="data_management/tourney_form.php" target="dataFrame" class="navLink">CREATE TOURNAMENT</a>
                <a href="#" target="dataFrame" class="navLink">THREE</a>
            </div>
            <p>&nbsp;</p>
            <h3>!!!!! DANGER ZONE !!!!!</h3>
            <div class="navPanel" id="dbManagementPanel">
                <a href="db_management/conn_check.php" target="dataFrame" class="navLink">CHECK DB CONNECTION</a>
                <a href="db_management/reinitialize.php" target="dataFrame" class="navLink">RE-INITIALIZE DB</a>
                <a href="#" target="dataFrame" class="navLink" >SHOW RAW DB</a>
            </div>
            <p>&nbsp;</p>
        </div>
    </body>
</html>