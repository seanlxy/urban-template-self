$('.onoffcheckbox').checkbox({
      cls:'jquery-checkbox',
      empty:'css/images/empty.png'
    });
$('.tooltip').tipsy({gravity: 'w', fade: true });
$(window).keypress(function(event) {
    if (!(event.which == 115 && event.ctrlKey)) return true;
    submitForm('save',1);
    event.preventDefault();
    return false;
});

function highMenu(menu) {
    var menu;
    menu = "menu_" + menu;
    document.getElementById(menu).style.border="1px solid #000000";
    document.getElementById(menu).style.backgroundColor="#E4E9ED";
}

function lowMenu(menu) {
    var menu;
    menu = "menu_" + menu;
    document.getElementById(menu).style.border="1px solid transparent";
    document.getElementById(menu).style.backgroundColor="transparent";
}
function buttonHigh(button) {
    var button;
    document.getElementById(button).style.border="1px solid #000000";
    document.getElementById(button).style.backgroundColor="#DCF3FA";
}
function buttonLow(button) {
    var button;
    document.getElementById(button).style.border="1px solid transparent";
    document.getElementById(button).style.backgroundColor="transparent";
}

function submitForm(type,required) {
    var type;
    var found = 1;
    var required;
    $('#action').val(type);
    $('form').submit();
}


function NewWindow(mypage, myname, w, h, scroll) {
    var winl = (screen.width - w) / 2;
    var wint = (screen.height - h) / 2;
    winprops = 'status=yes,height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
    win = window.open(mypage, myname, winprops)
    if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
}
