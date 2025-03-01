function resizeIframe(obj) {
    obj.style.height = "200px";
    obj.style.width = "100px";
    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
    obj.style.width = obj.contentWindow.document.documentElement.scrollWidth + 'px';
}

function getURL(path) {
    if (path == undefined) {
        path = "";
    }
    console.log(window.location.href + path);
    return window.location.href + path;
}