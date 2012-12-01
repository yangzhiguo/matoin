function sendmailagain(uri){
    mtAjx({type:'get', url:uri, cache:false}, '', function(d){
        if(!isUndefined(d)){
            if(d == 1){
                showMsgbox('验证邮件已发送');
            }else if(d == -2){
                redirect();
            }else if(d == -1){
                showMsgbox('请2分钟后再发送验证邮件', 'error');
            }else{
                showMsgbox('发送失败，请换个邮箱注册', 'error');
            }
        }
    });
    return false;
}