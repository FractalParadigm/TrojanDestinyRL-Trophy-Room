function resizeIframe(obj) {
    obj.style.height = "200px";
    obj.style.width = "100px";
    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
    obj.style.width = obj.contentWindow.document.documentElement.scrollWidth + 'px';
}