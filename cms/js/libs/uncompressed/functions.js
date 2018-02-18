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
if(typeof openFileBrowser != 'function')
{
    function openFileBrowser(w)
    {
        var winl = (screen.width - 1000) / 2;
        var wint = (screen.height - 600) / 2;
        var mypage = jsVars.baseUrl+"/filemanager/index.html?NetZone="+w+"&lang=en";

        var myname = "imageSelector";
        winprops = 'status=yes,height=600,width=1000,top='+wint+',left='+winl+',scrollbars=auto,resizable'
        win = window.open(mypage, myname, winprops)
        if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
    }
}
if(typeof SetUrl != 'function')
{
    function SetUrl(p,w,h) 
    {
        var p;
        var w;
        var h;
        document.getElementById(w).value=p;
    }
}
if(typeof clearValue != 'function')
{
    function clearValue(e) 
    {
        document.getElementById(e).value = '';
    }
}
$(function(){
    $('#checkall').on('change', function () {
        var self = $(this),
        isChecked = self.is(':checked');
        $('.checkall').each(function(i, item){
            var ths = $(item);
            if(isChecked)
            {
                ths.parents('tr').addClass('selected');
                ths.prop('checked', isChecked);
            }
            else
            {
                ths.parents('tr').removeClass('selected');
                ths.prop('checked', isChecked);
            }
        });
        
    });
});
