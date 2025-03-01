<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
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
                <a href="#" target="dataFrame" class="navLink">DISPLAY ALL USERS</a>
            </div>
            <p>&nbsp;</p>
            <h3>TOURNEY MANAGEMENT</h3>
            <div class="navPanel" id="tourneyManagementPanel">
                <a href="#" target="dataFrame" class="navLink">ADD VICTORY</a>
                <a href="#" target="dataFrame" class="navLink">TWO</a>
                <a href="#" target="dataFrame" class="navLink">THREE</a>
            </div>
            <p>&nbsp;</p>
            <h3>!!!!! DANGER ZONE !!!!!</h3>
            <div class="navPanel" id="dbManagementPanel">
                <a href="db_management/conn_check.php" target="dataFrame" class="navLink">CHECK DB CONNECTION</a>
                <a href="db_management/reinitialize.php" target="dataFrame" class="navLink">RE-INITIALIZE DB</a>
                <a href="#" target="dataFrame" class="navLink">SHOW RAW DB</a>
                <a href="#" target="dataFrame" class="navLink">FOUR</a>
            </div>
            <p>&nbsp;</p>
        </div>
    </body>
</html>