function add_album(obj, input){
    var form = $(obj).parent();
    var name = form.find('input[name="newalbumname"]');
    var vl = $.trim(name.val()), dt = $.trim(name.attr('alt'));
    if(vl == '' || vl == dt){
        name.focus();
        return false;
    }
    if(strlen(vl)> 16){
        showMsgbox('专辑名太长了', 'error');
        return false;
    }
    var oldWAIT = WAIT;
    WAIT = '<span><img src="static/image/preview.gif" alt="创建中..." /></span>';
    mtAjxPost('albumaddform' + input, 'newalbum' + input, 'newalbum' + input, 'doalbumadd' + input, function (data){
        var newalbum = $('#newalbum' + input);
        if(data == 0){
            showMsgbox('已经有这个专辑了', 'error');
        }else{
            var prc = newalbum.clone().insertBefore(newalbum).removeAttr('id').removeAttr('style').get(0).children[0];
            name.val('');
            selectalbumid(parseInt(prc.getAttribute('alt')), prc);
        }
        newalbum.hide().html('');
        $('#doalbumadd' + input).removeAttr('disabled');
    });
    WAIT = oldWAIT;
    return false;
}
function selectalbumid(albumid, obj){
    var $this = $(obj);
    var albumbx = $this.parent().parent().parent();
    var input = albumbx.attr('data-spm');
    albumbx.hide().prev().find('.showalbum').html(obj.innerHTML);
    albumbx.prev().find('.cancelalbum').show();
    $('#' + input).val(parseInt(albumid));
    return false;
}

var HASLOGIN = 0;
function showalbum(obj){
    if( ! HASLOGIN){
        if(mtAjxChk('member/check/checklogin', null, '0')){
            mtWindow('login', 'member/login_float?redirect=-1');
            return false;
        }
    }
    HASLOGIN = 1;
    $(obj).parent().next('.album-box').show().find('ul').css({height:'160px'});
    return false;
}
function cancelalbum(obj, input){
    $(obj).hide().parent().find('.showalbum').text('选择专辑');
    $('#'+ input).val('');
    return false;
}
function closealbum(obj){
    $(obj).parent().hide();
    return false;
}