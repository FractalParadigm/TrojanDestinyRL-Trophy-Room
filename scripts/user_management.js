function randomPassword() {
    // Grab the length of password the user wants
    var passwordLength = document.getElementById("passwordLength").value;
    var password = "";

    // The character set of the password. Modify this at your discretion
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

    // Get random characters until we're at the desired length
    for (var i = 0; i < passwordLength; i++) {
        password += charset.charAt(Math.floor(Math.random() * charset.length));
    }

    // Set the password field to what we've generated
    document.getElementById("password").value = password;
}

function verifyInput() {
    // This function ensures that the form was filled out properly.
    // It seems way easier to do this through JS than PHP but I could be wrong

    // Check if the username is filled out
    var username = document.forms["userForm"]["username"].value;

    if (username == "") {
        alert ("Must enter a username!");
        return false;
    }

    // Check if a password is required, if so, make sure one is entered
    var password = document.forms["userForm"]["password"].value;
    if (!(document.getElementById("none").checked) && password == "") {
        alert ("Must enter a password! Or select \"None\" for no password (not available for administrator accounts).");
        return false;
    }

    // Ensure the password (if enabled) is at least 6 characters in length
    if (!(document.getElementById("none").checked) && password.length < 6) {
        alert ("Password must have a minimum length of 6 characters.");
        return false;
    }

    // Make sure the passwords match
    if (!passwordConfirm()) {
        alert ("Passwords do not match!");
        return false;
    }

    if (!usernameConfirm()) {
        alert ("Username already taken!");
        return false;
    }
}

function displayPassword() {
    // This will check to see if we want the password visible, and sets it as such
    if (document.getElementById("showPassword").checked) {
        document.getElementById("password").type = "text";
    } else if (!(document.getElementById("showPassword").checked)) {
        document.getElementById("password").type = "password";
    }
}

function passwordConfirm() {
    // Check if the 'confirm' password matches the main one entered
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    // If the field is empty we'll hide the results
    if (confirmPassword == "") {
        document.getElementById("matchingPasswords").style.visibility = "hidden";
        document.getElementById("matchingPasswordsText").style.visibility = "hidden";
        return false;
    } else if (password == confirmPassword) { // If they match, show them green and return true
        document.getElementById("matchingPasswords").style.visibility = "visible";
        document.getElementById("matchingPasswords").style.color = "green" ;
        document.getElementById("matchingPasswords").innerHTML = "&#10003;&nbsp;";
        document.getElementById("matchingPasswordsText").style.visibility = "visible";
        document.getElementById("matchingPasswordsText").innerHTML = "Match!";
        return true;
    } else if (password != confirmPassword) {
        document.getElementById("matchingPasswords").style.visibility = "visible";
        document.getElementById("matchingPasswords").style.color = "red";
        document.getElementById("matchingPasswords").innerHTML = "&#935;&nbsp;";
        document.getElementById("matchingPasswordsText").style.visibility = "visible";
        document.getElementById("matchingPasswordsText").innerHTML = "Not a match!";
        return false;
    } 
}

function usernameConfirm() {
    // Get the username entered
    var username = document.getElementById("username").value;

    // If the username is blank, clear the notice
    // Otherwise, we'll check the userlist created by PHP which was converted for JS
    // If the name is there, return false
    if (username == "") {
        document.getElementById("confirmUsername").style.visibility = "hidden";
        return false; 
    } else if (userList.includes(username)) {
        document.getElementById("confirmUsername").style.visibility = "visible";
        document.getElementById("confirmUsername").style.color = "red";
        document.getElementById("confirmUsername").innerHTML = "Name Taken";
        return false; // we return false for a match - a match is not what we want!
    } else if (!userList.includes(username)) {
        document.getElementById("confirmUsername").style.visibility = "visible";
        document.getElementById("confirmUsername").style.color = "green";
        document.getElementById("confirmUsername").innerHTML = "Name Available!";
        return true; // this means the user does not already exist and is good to go
    }
}