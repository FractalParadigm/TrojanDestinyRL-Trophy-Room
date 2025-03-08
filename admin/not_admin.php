<?php 
session_start();
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="../styles/primary.css" />
        <link rel="stylesheet" href="../styles/admin.css" />
        <link rel="stylesheet" href="../styles/admin_nav.css" />
        <script src="/scripts/tools.js"></script>
        <script>verifyPageInFrame()</script>
        <title>NOT ALLOWED</title>
    </head>

    <body id="notAnAdmin">
        <h3>You're not allowed to be here!</h3>
        <p>You don't have the necessary privileges to view this content</p>
        <p>If you believe this to be an error, contact another admin, or your systems administrator.</p>
    </body>

    
</html>