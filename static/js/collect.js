var HASLOGIN = 0;
function collect(formid, loadingid, submitid){
    if(!HASLOGIN){
        if(mtAjxChk('member/check/checklogin', null, '0')){
            mtWindow('login', 'member/login_float?redirect=-1');
            return false;
        }
    }
    HASLOGIN = 1;
    var loading = $('#' + loadingid),
        submit  = $('#' + submitid),
        keepwait = WAIT;

    if($('#' + formid).find('input[name="albumid"]').val() == ''){
        $('body,html').animate({scrollTop:parseInt($('.showalbum').offset().top) - 45 + 'px'});
        showMsgbox('请选择一个专辑');
        return false;
    }

    WAIT = '<span><img src="static/image/preview.gif" title="给力发布中..." alt="给力发布中..." /></span>';
    mtAjxPost(formid, loadingid, loadingid, submitid, function (data){
        var nt = '';
        if(isUndefined(data)){
            nt = AJAXERROR;
        }else{
            var dr = parsejson(data);
            switch(dr.sta){
                case 1:
                    setTimeout(function(){redirect(dr.msg)}, 500);
                    nt = '发布成功，跳转中...';
                    break;
                default :
                    nt = dr.msg;
                    break;
            }
        }
        submit.removeAttr('disabled');
        loading.html(nt);
    });
    WAIT = keepwait;
    return false;
}