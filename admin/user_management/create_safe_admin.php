<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="/styles/admin.css" />
        <link rel="stylesheet" href="/styles/admin_nav.css" />
        <link rel="stylesheet" href="/styles/user_management.css" />
        <?php include ("../db_config.php");?> <!-- Our password-length variable is stored here -->
        <script src="/scripts/user_management.js"></script>
        <title>ADMIN CREATION FORM</title>
    </head>

    <body id="generalBody">
        <div id="userFormPanel">
            <h2>SAFE ADMIN CREATION</h2>
            <p>This form is used to create safe administrators - users who won't be deleted by a (re)initilization of the database</p>
            <hr>
            <p></p>
            <form id="userForm" action="add_safe_admin.php" onsubmit="return verifyInput()" method="POST" target="dataFrame">
                <!-- THIS DIV IS FOR INPUT -->
                <div id="textInputArea">
                    <label for="username" class="inputLabel" >Username:</label>
                    <input type="text" id="username" name="username" class="newLine" maxlength="30" required/>
                    <label for="password" class="inputLabel">Password:</label>
                    <input type="password" id="password" name="password" required/>
                    <input type="checkbox" id="showPassword" name="showPassword" class="passwordOptions" onclick="displayPassword()"/>
                    <label for="showPassword" class="passwordOptions" id="displayPassword" class="newLine">(show)</label>
                    <label for="discord" class="newLine">Discord:</label>
                    <input type="text" id="discord" name="discord" class="newLine"  maxlength="50"/>
                    <label for="twitch" class="newLine">Twitch:</label>
                    <input type="text" id="twitch" name="twitch" class="newLine" maxlength="50" />
                    <label for="youtube" class="newLine">Youtube:</label>
                    <input type="text" id="youtube" name="youtube" class="newLine" maxlength="50" />
                </div>
                <hr>
                <!-- THIS DIV IS FOR EXTRA SETTINGS -->
                <div id="extraOptions">
                    <h4>EXTRA OPTIONS</h4>
                    <p class="newLine">&nbsp;</p>
                    <input type="checkbox" id="isAdmin" name="isAdmin" value="isAdmin" class="extraOptions" checked  onclick="return false;">
                    <label for="isAdmin" class="extraOptions">Make administrator?</label>
                    <p class="newLine">
                    This is a safe admin. This person will have all of the privileges of a normal administrator, 
                    in addition to surviving database deletes (ONLY THE USER ACCOUNT, any saved game or replay 
                    data will NOT be saved!). Make absolutely certain this is the kind of account you want to create,
                     and that the person you give the credentials to is trustworthy. 
                    </p>
                    <p class="newLine"></p>
                </div>
                <p>&nbsp;</p>
                <input type="submit" value="CREATE" />
            </form>
            <p>&nbsp;</p>
        </div>
    </body>
</html>