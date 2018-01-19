var menuHtml;
var authHtml;
$(document).ready(function () {
    init();
});
function init() {

    menuHtml = handler.getMenu('menu');
    authHtml = handler.getMenu('auth');

    handler.adaptive();
    handler.eventON();
}