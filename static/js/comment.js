$(function(){
    $('#comm-ul li').live({
        'mouseover':function(){
            $(this).find('.comm-del').show();
        },
        'mouseout': function(){
            $(this).find('.comm-del').hide();
        }
    });
    $('#addcomment').focus(function(){
        $('#addcomment-label').stop().fadeOut(250);
    }).blur(function(){
            if($.trim($('#addcomment').val()) == ''){
                $('#addcomment-label').stop().fadeIn(250);
                $('#addcomment').val('');
            }
        });
    $('#doaddcomment').click(function(){
        if($.trim($('#addcomment').val()) == ''){
            $('<div class="comment-waring"></div>').appendTo($('#addcomment').parent()).show().fadeOut(500, function(){$('.comment-waring').remove()});
            return;
        }
        $('#doaddcomment').val('提交...');
        mtAjxPost('commentform', '', '', 'doaddcomment', function(da){
            if(isUndefined(da)){
                return false;
            }
            var d = parsejson(da);
            if(!parseInt(d.cid)){
                showMsgbox(da, 'error');
                $('#doaddcomment').val('提交').removeAttr('disabled');
                return false;
            }
            var dhtml = '<li class="clearfix"><a href="member/'+d.authorid+'" class="fl mr10"><img src="'+d.avatar+'" alt="'+d.author+'" /></a><div class="comm-box"><p class="clearfix"><a href="member/'+d.authorid+'" class="b fl">'+d.author+'</a><em class="ml10 fl c-9">'+d.dateline+'</em><a class="b fr" href="javascript:void(0);" onclick="reply_comment('+d.cid+',\''+d.author+'\')">回复</a><a class="comm-del c-9 mr10 fr" href="javascript:void(0);" onclick="delete_comment('+d.cid+',this)">删除</a></p><div class="pt10">'+d.message+'</div></div></li>';
            $(dhtml).hide().appendTo($('#comm-ul')).fadeIn();
            $('#doaddcomment').val('提交').removeAttr('disabled');
            $('#addcomment').val('');
            $('#comment-max').text('140');
            chtmls = [];
        });
    });
});

function reply_comment(cid, username){
    $('#addcomment-label').remove();
    $('#addcomment').focus().val('回复 ' + username + ': ');
    $('input[name="cid"]').val(parseInt(cid));
}
function delete_comment(cid,obj){
    mtAjx({type:'get', url:'comment/delete/' + cid, cache:false}, '', function(d){
        if(d == "1"){
            $(obj).parent().parent().parent().animate({'height':0, 'opacity':0}, 200, function(){
                $(this).remove();
            });
            chtmls = [];
        }
    });
}
function strlen_verify(obj, checklen, maxlen) {
    var v = obj.value, charlen = 0, maxlen = !maxlen ? 200 : maxlen, curlen = maxlen, len = strlen(v);
    if(curlen >= len) {
        $('#'+checklen).html(curlen - len);
    } else {
        obj.value = mb_cutstr(v, maxlen, false);
        obj.focus();
        obj.scrollTop = obj.scrollHeight;
        $('#'+checklen).html(0);
    }
}
function mb_cutstr(str, maxlen, dot) {
    var len = 0;
    var ret = '';
    var dot = !dot ? '...' : '';
    maxlen = maxlen - dot.length;
    for(var i = 0; i < str.length; i++) {
        len += 1;
        if(len > maxlen) {
            ret += dot;
            break;
        }
        ret += str.substr(i, 1);
    }
    return ret;
}
var chtmls = [];
function cmtpage(obj, item){
    var cpar = isUndefined(item) ? $(obj).attr('href').split('/').pop().split('?p=') : [item[0], item[1]];
    if(!isUndefined(chtmls[cpar[1]])){
        $('#comm-ul').stop().css({'opacity':0}).html(chtmls[cpar[1]][0]).animate({'opacity':1});
        $('.page').remove();
        $('<div class="page">' + chtmls[cpar[1]][1] + '</div>').appendTo($('.comm-list'));
        return false;
    }
    mtAjx({type:'get', url:'comment/pagination?itemid=' + parseInt(cpar[0]) + '&p=' + cpar[1], cache:true}, '', function(d){
        if(isUndefined(d) || d == ''){
            $('#comm-ul').html('');
            return false;
        }
        var chtml = '';
        var d = parsejson(d);
        for(var i in d.cmt){
            chtml +=
                '<li class="clearfix">' +
                    '<a href="member/'+d.cmt[i].authorid+'" class="fl mr10"><img src="'+d.cmt[i].avatar+'" alt="'+d.cmt[i].author+'" title="'+d.cmt[i].author+'" /></a>' +
                    '<div class="comm-box">' +
                    '<p class="clearfix">' +
                    '<a href="member/'+d.cmt[i].authorid+'" class="b fl">'+d.cmt[i].author+'</a>' +
                    '<em class="ml10 fl c-9">'+d.cmt[i].dateline+'</em>' +
                    (d.cmt[i].haslogin ? '<a class="b fr" href="javascript:void(0);" onclick="reply_comment('+d.cmt[i].cid+', \''+d.cmt[i].author+'\')">回复</a>' : '') +
                    (d.cmt[i].ismine ? '<a class="comm-del c-9 mr10 fr" href="javascript:void(0);" onclick="delete_comment('+d.cmt[i].cid+',this)">删除</a>' : '') +
                    '</p>' +
                    '<div class="pt10">'+d.cmt[i].message+'</div>' +
                    '</div>' +
                '</li>';
        }
        chtmls[cpar[1]] = [chtml, d.page];
        $('#comm-ul').stop().css({'opacity':0}).html(chtml).animate({'opacity':1});
        $('.page').remove();
        $('<div class="page">' + d.page + '</div>').appendTo($('.comm-list'));
    });
    return false;
}