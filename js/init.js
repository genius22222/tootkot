var menuHtml;
var authHtml;
$(document).ready(function () {
    init();
});
function init() {
    if ($(document).width() >= 1280){
    handler.adaptive($(document).width());
    }
    menuHtml = handler.getMenu('menu');
    authHtml = handler.getMenu('auth');


    handler.eventON();
}