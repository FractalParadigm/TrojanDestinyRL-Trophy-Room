<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="../styles/admin.css" />
        <link rel="stylesheet" href="../styles/admin_nav.css" />
        <script src="../scripts/trojan.js"></script>
        <title>ADMIN PANEL - Trojan's Trophy Room</title>
    </head>

    <body id="body">
        <div id="contentFrame">
            <h1>Trojan's Trophy Room</h1>
            <h2 id="adminHeader">ADMIN PANEL</h2>
            <iframe src="admin_nav.php" name="dataFrame" class="dataFrame" id="dataFrame" onload="resizeIframe(this);"></iframe>
            <div id="subNav">
                <a href="./" class="navLink" id="adminHomeButton">ADMIN HOME</a>
                <a href="../" class="navLink" id="mainHomeButton">MAIN HOME</a>
            </div>
        </div>
    </body>
</html>