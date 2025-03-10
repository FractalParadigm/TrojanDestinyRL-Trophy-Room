function randomPassword() {
    var password = "";
    var passwordLength = 8;

    // The character set of the password. Modify this at your discretion
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

    // Get random characters until we're at the desired length
    for (var i = 0; i < passwordLength; i++) {
        password += charset.charAt(Math.floor(Math.random() * charset.length));
    }

    // Set the password field to what we've generated
    //document.getElementById("password").value = password;
    //document.getElementById("confirmPassword").value = password;
    console.log(password);
    return password;
}

function verifyInput() {
    // This function ensures that the form was filled out properly.
    // It seems way easier to do this through JS than PHP but I could be wrong

    // Check if the username is filled out
    var username = document.forms["userForm"]["username"].value;
    // Alert if not
    if (username == "") {
        alert ("Must enter a username!");
        return false;
    }
    // Check if the name is already taken
    if (!usernameConfirm()) {
        alert ("Username already taken!");
        return false;
    }

    var password = document.forms["userForm"]["password"].value;
    // Ensure the password is at least 6 characters in length
    if (password.length < 6) {
        alert ("Password must have a minimum length of 6 characters.");
        return false;
    }

    // Make sure the passwords match
    if (!passwordConfirm()) {
        alert ("Passwords do not match!");
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
        document.getElementById("confirmPassword").style.outline = null;
        return false;
    } else if (password == confirmPassword) { // If they match, show them green and return true
        document.getElementById("matchingPasswords").style.visibility = "visible";
        document.getElementById("matchingPasswords").style.color = "green" ;
        document.getElementById("matchingPasswords").innerHTML = "&#10003;&nbsp;";
        document.getElementById("confirmPassword").style.outline = "1px solid green";
        document.getElementById("matchingPasswordsText").style.visibility = "visible";
        document.getElementById("matchingPasswordsText").innerHTML = "Match!";
        return true;
    } else if (password != confirmPassword) {
        document.getElementById("matchingPasswords").style.visibility = "visible";
        document.getElementById("matchingPasswords").style.color = "red";
        document.getElementById("matchingPasswords").innerHTML = "&#935;&nbsp;";
        document.getElementById("confirmPassword").style.outline = "2px solid red";
        document.getElementById("matchingPasswordsText").style.visibility = "visible";
        document.getElementById("matchingPasswordsText").innerHTML = "Not a match!";
        return false;
    } 
}

function passwordConfirmLite() {
    // This is used when we don't have enough space for the "matches" text, i.e. the user page
    // Check if the 'confirm' password matches the main one entered
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    // If the field is empty we'll hide the results
    if (confirmPassword == "") {
        document.getElementById("confirmPassword").style.outline = null;
        return false;
    } else if (password == confirmPassword) { // If they match
        document.getElementById("confirmPassword").style.outline = "1px solid green";
        return true;
    } else if (password != confirmPassword) {
        document.getElementById("confirmPassword").style.outline = "2px solid red";
        return false;
    } 
}

function usernameConfirm() {
    // Get the username entered and convert to lower case
    var username = document.getElementById("username").value.toLowerCase();
    // Temporarily convert the userlist to lower case. This will allow us to compare input vs. saved
    var listOfUsers = userList.map(e => e.toLowerCase());

    // If the username is blank, clear the notice
    // Otherwise, we'll check the userlist created by PHP which was converted for JS
    // If the name is there, return false
    if (username == "") {
        document.getElementById("confirmUsername").style.visibility = "hidden";
        document.getElementById("username").style.outline = null;
        return false; 
    } else if (listOfUsers.includes(username)) {
        document.getElementById("confirmUsername").style.visibility = "visible";
        document.getElementById("confirmUsername").style.color = "red";
        document.getElementById("confirmUsername").innerHTML = "Taken";
        document.getElementById("username").style.outline = "2px solid red";
        return false; // we return false for a match - a match is not what we want!
    } else if (!listOfUsers.includes(username)) {
        document.getElementById("confirmUsername").style.visibility = "visible";
        document.getElementById("confirmUsername").style.color = "green";
        document.getElementById("confirmUsername").innerHTML = "";
        document.getElementById("username").style.outline = "1px solid green";
        return true; // this means the user does not already exist and is good to go
    }
}

function checkPasswordRequirements() {
    var password = document.getElementById("password").value;
    console.log(password);

    if (password == "") {
        document.getElementById("password").style.outline = null;
    } else if (password.length < 6) {
        document.getElementById("password").style.outline = "2px solid red";
    } else {
        document.getElementById("password").style.outline = "1px solid green";        
    }
}

function togglePWChange() {
    // This function handles the switch between showing the socials edit panel and the password change panel
    var socialsDiv = document.getElementById("accountSocialsPanel");

    var pwChangeDiv = document.getElementById("passwordChangePanel");

    if (pwChangeDiv.style.display == "none") {
        socialsDiv.style.display = "none";
        socialsDiv.style.zIndex = "-1";
        pwChangeDiv.style.display = "flex";
        pwChangeDiv.style.zIndex = "1";
    } else if (pwChangeDiv.style.display == "flex") {
        socialsDiv.style.display = "flex";
        socialsDiv.style.zIndex = "1";
        pwChangeDiv.style.display = "none";
        pwChangeDiv.style.zIndex = "-1";
    } else { 
        socialsDiv.style.display = "none";
        socialsDiv.style.zIndex = "-1";
        pwChangeDiv.style.display = "flex";
        pwChangeDiv.style.zIndex = "1";
    }
}

function editUser() {
    console.log("YAASSS");
    var div = document.getElementById("userEditFrameDiv");
    username = document.getElementById("user").value;
    var html = "";

    
    html += "<iframe src=\"/admin/user_management/user_edit_form.php?username=" + username + "\" name=\"dataFrame\" class=\"dataFrame\" id=\"dataFrame\" onload=\"resizeIframe(this);var obj=parent.document.getElementById('dataFrame');resizeIframe(obj);\"></iframe>";

    div.innerHTML = html;

    console.log(html);
}

function setPrivilegeLevel(privileges) {
    switch (privileges){
    case 0:
        document.getElementById("regular").checked = true;
        break;
    case 1:
        document.getElementById("administrator").checked = true;
        break;
    case 2:
        document.getElementById("moderator").checked = true;
        break;
    }
}