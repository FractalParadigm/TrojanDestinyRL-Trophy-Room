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

function togglePassword() {
    // This function features various 'toggles' for the checkboxes on the manual user creation screen

    // Check if the 'no password' option is checked.
    // A password can be set later, if necessary

    if (document.getElementById("none").checked) {  // IF WE HAVE NO PASSWORD OPTION CHECKED
        var enabled = true; // enabled variable status set false
        // Disable all the checkboxes and password length inputs
        document.getElementById("password").disabled = true;
        document.getElementById("showPassword").disabled = true;
        document.getElementById("random").disabled = true;
        document.getElementById("passwordLength").disabled = true;
        // Uncheck the random password mark
        document.getElementById("random").checked = false;
    } else if (!(document.getElementById("none").checked)) {  // IF WE UNCHECK THE OPTION, RE-ENABLE EVERYTHING
        var enabled = false; // enabled variable set true!
        // Re-enable inputs
        document.getElementById("password").disabled = false;
        document.getElementById("showPassword").disabled = false;
        document.getElementById("random").disabled = false;
        document.getElementById("passwordLength").disabled = false;
    }

    // This will check to see if we want the password visible, and sets it as such
    if (document.getElementById("showPassword").checked && !enabled) {
        document.getElementById("password").type = "text";
    } else if (!(document.getElementById("showPassword").checked) && !enabled) {
        document.getElementById("password").type = "password";
    }
    
    // This will remove the password from the field when 'random' is unchecked
    if (!(document.getElementById("random").checked) && enabled) {
        document.getElementById("password").value = "";
    }

}

function forcePassword() {
    // This function forces the use of a password when we try to make the user an administrator
    // An admin without a password could be bad news....

    if (document.getElementById("isAdmin").checked) { // ensure the box is checked
        document.getElementById("none").checked = false; // Force-uncheck the 'none' option
        togglePassword(); // Generate a password
        document.getElementById("none").disabled = true; // Disable the 'none' option
    } else { 
        document.getElementById("none").disabled = false; // Re-enable the 'none' option
    }
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
}