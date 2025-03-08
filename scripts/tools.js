function resizeIframe(obj) {
    obj.style.height = "200px";
    obj.style.width = "100px";
    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
    obj.style.width = obj.contentWindow.document.documentElement.scrollWidth + 'px';
}

function getURL(path) {
    // Gets the URL so we can re-direct the user back to where they came from
    if (path == undefined) {
        path = "";
    }
    return window.location.href + path;
}

function verifyPageInFrame() {
    // Verify that the page was loaded in an iFrame
    // Otherwise back to the homepage they go!
    var mainURL = window.location.origin;

    if (window.self !== window.top) {
    } else {
        window.location = mainURL;
    }
}

function redirect(location, address) {
    
    switch (location) {
        case "twitch":
            var link = "https://twitch.tv/" + address;
        break;
        case "discord":
            var link = "https://discordapp.com/users/" + address;
        break;
        default:
            var link = address;
    }
        
    window.open(link).focus();
}