<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="/styles/primary.css" />
        <link rel="stylesheet" href="/styles/admin.css" />
        <link rel="stylesheet" href="/styles/admin_nav.css" />
        <link rel="stylesheet" href="/styles/user_management.css" />
        <script src="/scripts/user_management.js"></script>
        <script src="/scripts/tools.js"></script>
        <script>verifyPageInFrame()</script>
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
                <div id="textInputArea">
                    <label for="username" class="inputLabel" >Username:</label>
                    <input type="text" id="username" name="username" maxlength="30" required/>
                    <label for="password" class="inputLabel newLine">Password:</label>
                    <input type="password" id="password" name="password" minlength="6" required/>
                    <input type="checkbox" id="showPassword" name="showPassword" class="passwordOptions" onclick="displayPassword()"/>
                    <label for="showPassword" class="passwordOptions" id="displayPassword" class="newLine">(show)</label>
                    <label for="discord" class="newLine">Discord:</label>
                    <input type="text" id="discord" name="discord" class="newLine"  maxlength="50"/>
                    <label for="discord" class="newLine">Discord Link:</label>
                    <input type="text" id="discordLink" name="discordLink" class="newLine"  maxlength="50"/>
                    <label for="twitch" class="newLine">Twitch:</label>
                    <input type="text" id="twitch" name="twitch" class="newLine" maxlength="50" />
                    <label for="youtube" class="newLine">Youtube:</label>
                    <input type="text" id="youtube" name="youtube" class="newLine" maxlength="50" />
                    <label for="youtube" class="newLine">Youtube Link:</label>
                    <input type="text" id="youtubeLink" name="youtubeLink" class="newLine" maxlength="50" />
                </div>
                <hr>
                <!-- THIS DIV IS FOR EXTRA SETTINGS -->
                <div id="extraOptions">
                    <h4>EXTRA OPTIONS</h4>
                    <p class="newLine">&nbsp;</p>
                    <input type="checkbox" id="privileges" name="privileges" class="extraOptions">
                    <label for="privileges" class="extraOptions">Make administrator?</label>
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