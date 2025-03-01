<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="../../styles/admin.css" />
        <link rel="stylesheet" href="../../styles/admin_nav.css" />
        <link rel="stylesheet" href="user_management.css" />
        <?php include ("../db_config.php");?> <!-- Our password-length variable is stored here -->
        <script src="user_management.js"></script>
        <title>USER CREATION FORM</title>
    </head>

    <body id="generalBody">
        <div id="userFormPanel">
            <h2>USER CREATION</h2>
            <p>This form is used to manually add new users to the system</p>
            <hr>
            <p></p>
            <form id="userForm" action="add_user.php" onsubmit="return verifyInput()" method="POST" target="dataFrame">
                <!-- THIS DIV IS FOR INPUT -->
                <div id="inputArea">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" />
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" />
                    <label for="discord">Discord:</label>
                    <input type="text" id="discord" name="discord" />
                    <label for="twitch">Twitch:</label>
                    <input type="text" id="twitch" name="twitch" />
                    <label for="youtube">Youtube:</label>
                    <input type="text" id="youtube" name="youtube" />
                </div>
                <hr>
                <!-- THIS DIV IS FOR PASSWORD SETTINGS -->
                <div id="passwordOptions">
                    <h4>PASSWORD OPTIONS</h4>
                    <p class="newLine"></p>
                    <input type="checkbox" id="showPassword" name="showPassword" class="passwordOptions" onclick="togglePassword()"/>
                    <label for="showPassword" class="passwordOptions">Show Password</label>
                    <p class="newLine"></p>
                    <input type="checkbox" id="random" name="random" class="passwordOptions" onclick="randomPassword();togglePassword();"/>
                    <label for="random" class="passwordOptions">Random</label>
                    <label for="passwordLength">Length of password:&nbsp;</label>
                    <input type="number" id="passwordLength" value="<?php echo $passwordLength ?>" min="6" max="20" onchange="randomPassword();togglePassword();">
                    <p class="newLine"></p>
                    <input type="checkbox" id="none" name="none" class="passwordOptions" onclick="togglePassword()"/>
                    <label for="none" class="passwordOptions">None (can be set later)</label>
                </div>
                <hr>
                <!-- THIS DIV IS FOR EXTRA SETTINGS -->
                <div id="extraOptions">
                    <h4>EXTRA OPTIONS</h4>
                    <p class="newLine">&nbsp;</p>
                    <input type="checkbox" id="isAdmin" name="isAdmin" class="extraOptions" onclick="forcePassword()">
                    <label for="isAdmin" class="extraOptions">Make administrator?</label>
                    <p class="newLine">An administrator will have FULL access to the administrator panel. In the hands of the wrong user, THIS COULD CAUSE SERIOUS DAMAGE AND IRREPARABLE HARM TO YOUR SERVER! Proceed with caution, and only with those you trust.</p>
                    <p class="newLine"></p>
                </div>
                <p>&nbsp;</p>
                <input type="submit" value="CREATE" />
            </form>
            <p>&nbsp;</p>
        </div>
    </body>
</html>