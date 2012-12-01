$(function(){
    var pas = 0;
    var dely = 400;
    $(window).scroll( function(){
        if($(window).scrollTop()> 10){
            if(pas) return;
            $('.action-bar:not(:animated)').animate({top:'250px'}, dely);
            pas = 1;
        }else{
            if(!pas) return;
            $('.action-bar:not(:animated)').animate({top:'120px'}, dely, 'linear',function(){pas = 0;});
        }
    });
    $("#aside-fixed").barfixed({top:-45});
});
function changeDepict(olddepict, newdepict){
    var image_depict = $('#image-depict');
    var newd = $.trim(newdepict), oldd = $.trim(olddepict);
    if(newd != '' && escape(newd) != oldd){
        mtAjxPost('editdepict', 'ed-loading', 'ed-loading', '', function(data){
            if(data == "1"){
                image_depict.text(newd).bind('click', crt_depict_form);
            }
            else{
                setTimeout("$('#ed-loading').hide()", 1000);
            }
        });
        return false;
    }else{
        image_depict.text(unescape(oldd)).bind('click', crt_depict_form);
    }
}
$.fn.barfixed = function (options){
    var _default = {
        className:"aside-fixed",
        top:0
    };
    var _opts = $.extend({},_default,options);
    return $(this).each(function() {
        var fixedDiv = $(this), H = _opts.top, Y = fixedDiv.get(0);
        if($.browser.msie && $.browser.version == '8.0'){H = H * 2;}
        if($.browser.msie && $.browser.version == '7.0'){H = H + 1;}
        while (Y) { H += Y.offsetTop;Y = Y.offsetParent}
        $(window).scroll(function (){
            var s = document.body.scrollTop || document.documentElement.scrollTop;
            s > H ? fixedDiv.addClass(_opts.className) : fixedDiv.removeClass(_opts.className);
        })
    });
};