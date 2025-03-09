<?php 
session_start();
$redirect = $_GET["redirect"];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="/styles/primary.css" />
        <link rel="stylesheet" href="/styles/login.css" />
        <script src="/scripts/tools.js"></script>
        <script>verifyPageInFrame()</script>
        <script src="/scripts/user_management.js"></script>
        <title>ADMIN PANEL - Trojan's Trophy Room</title>
    </head>

    <body id="loginBody">
        <h3 id="loginNotice">Change Password</h3>
        <div id="loginPanel">
            <form id="loginForm" onsubmit="return verifyInput()" action="/login.php?redirect=<?php echo $redirect; ?>" method="POST">
                <div id="inputArea">
                    <label for="oldPassoword">Username:</label>
                    <input type="text" name="username" id="username" required>
                    <p class="newLine"></p>
                    <label for="newpassword">Password:</label>
                    <input type="newpassword" name="newpassword" id="newpassword" minlength="6" required>
                    <p class="newLine"></p>
                    <label for="confirmNewPassword">Password:</label>
                    <input type="confirmNewPassword" name="confirmNewPassword" id="confirmNewPassword"  minlength="6"  oninput="passwordConfirm()" required>
                    <p class="newLine"></p>
                    <label for="showPassword" id="showPasswordLabel">Show Password: &nbsp;</label>
                    <input type="checkbox" name="showPassword" id="showPassword"  onchange="displayPassword();">
                    <p class="newLine">&nbsp;</p>
                </div>
                <div id="submitButton">
                    <input type="submit" value="Log In">
                </div>
            </form>
        </div>
        <p class="newLine"></p>
    </body>
</html>