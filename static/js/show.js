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

    var wrapObj = $('#pic-area');
    wrapObj.mousemove(function(e){
        var ps = wrapObj.offset();
        var ps_width = wrapObj.width();
        var nxt = e.clientX > (ps.left+ps_width/2);
        var curClass = nxt ? 'pic-mouse-next' : 'pic-mouse-prev';
        wrapObj.attr('class',curClass);
    });

    wrapObj.click(function(e){
        var ps = wrapObj.offset();
        var ps_width = wrapObj.width();
        var nxt = e.clientX > (ps.left+ps_width/2);
        if(nxt){
            showNext();
        }else{
            showPrev();
        }
    });
});
function showNext(){
    var nextid = 0;
    if(LID.length> 0){
        for(var i = 0; i<LID.length; i++){
            if(LID[i] == PID && !isUndefined(LID[i+1])){
                nextid = LID[i+1];
            }
        }
        if(nextid> 0){
            redirect('view/'+nextid);
        }
    }
}
function showPrev(){
    var previd = 0;
    if(LID.length> 0){
        for(var i = 0; i<LID.length; i++){
            if(LID[i] == PID && !isUndefined(LID[i-1])){
                previd = LID[i-1];
            }
        }
        if(previd> 0){
            redirect('view/'+previd);
        }
    }
}

function changeDepict(oldDepict, newDepict){
    var image_depict = $('#image-depict');
    var newD = $.trim(newDepict), oldD = $.trim(oldDepict);
    if(newD != '' && escape(newD) != oldD){
        mtAjxPost('editdepict', 'ed-loading', 'ed-loading', '', function(data){
            if(data == "1"){
                image_depict.text(newD).bind('click', crt_depict_form);
            }
            else{
                setTimeout("$('#ed-loading').hide()", 1000);
            }
        });
        return false;
    }else{
        image_depict.text(unescape(oldD)).bind('click', crt_depict_form);
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