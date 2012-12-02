var WAIT = '加载中...';
var AJAXERROR = '请求失败，请稍后重试。';
function _(id){
    return !id ? null : document.getElementById(id);
}
function isUndefined(v){
    return typeof v == 'undefined';
}
function mt_createStyleSheet(sheets){
    var headTmp = $('head').eq(0);
    for(var i in sheets){
        if(document.createStyleSheet){
            document.createStyleSheet(sheets[i]);
        }else{
            var linkTmp = $('<link rel="stylesheet" type="text/css" />');
            linkTmp.attr({'href':sheets[i]});
            headTmp.append(linkTmp);
        }
    }
}
function parsejson(str){
    var d = '';
    try{
        d = (new Function('', 'return '+str))();
    }catch(e){
        d = str;
    }
    return d;
}
function redirect(url){
    url = isUndefined(url) ? '' : url;
    if(!url.match(/http[s]?:\/\//)){
        url = 'http://localhost/matoin/' + url;
    }
    window.location.href = url;
}
function checkemail(str){
    return /\w+((-\w+)|(\.\w+))*@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(str);
}
function strlen(str) {
    return ($.browser.msie && str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length : str.length;
}
function explode(sep, string) {
    return string.split(sep);
}
function mtLoading(w){
    var w_ = !isUndefined(w) && w ? w : WAIT;
    $('#append_parent').append('<div id="ajxwaitid">' + w_ + '</div>');
}
var showDialogST = null;
function showDialog(msg, mode, tile, func, funccancel, tip, confirmtxt, canceltxt, closetime, locationtime) {
    clearTimeout(showDialogST);
    tip  = isUndefined(tip) ? '' : tip;
    mode = isUndefined(mode) ? 'alert' : mode;  //['confirm', 'notice', 'right']
    var menuid = 'mt_dialog';
    if(_(menuid)){mtHide(menuid);}
    closetime = isUndefined(closetime) ? '' : closetime;
    var closefunc = function () {
        if(typeof func == 'function') func();
        else eval(func);
        mtHide(menuid);
    };
    var cfmtxt = '确定';
    if(closetime) {
        tip = closetime + ' 秒后窗口关闭';
        showDialogST = setTimeout(closefunc, parseInt(closetime) * 1000);
    }
    locationtime = isUndefined(locationtime) ? '' : locationtime;
    if(locationtime) {
        tip = locationtime + ' 秒后页面跳转';
        showDialogST = setTimeout(closefunc, parseInt(locationtime) * 1000);
        cfmtxt = '立即跳转';
    }
    cfmtxt = confirmtxt ? confirmtxt : cfmtxt;
    canceltxt  = canceltxt ? canceltxt : '取消';

    $('#append_parent').append('<div class="mtmenu" id="' + menuid + '" style="display:none;"></div>');
    var et = 'onmousedown="mtDrag(_(\'' + menuid + '\'), event, 1)" ondblclick="mtHide(\'' + menuid + '\')"';
    var hidedom = !$.browser.msie ? '<style>object{visibility:hidden;}</style>' : '';
    var s = hidedom
        + '<table cellpadding="0" cellspacing="0"><tr><td class="bc-ff">'
        + '<h3 class="fn p10 cur-m"' + et + '>'
        + '<a class="fr close block" href="javascript:void(0);" id="' + menuid + '_close" title="关闭" onclick="mtHide(\'' + menuid + '\')">x</a>'
        + '<span>' + (tile ? tile : '提示信息') + '</span></h3>';
    s += '<div class="p10 pt5 w350 dialog-' + mode + '"><p>' + msg + '</p></div>';
    s += '<div class="p10 bc-eb tr">' + (tip ? '<span class="c-9 mr10">' + tip + '</span>' : '');
    s += '<input class="btn w50 mr10" id="' + menuid + '_submit" value="' + cfmtxt + '" type="button" />';
    s += mode == 'confirm' ? '<input class="btn w50" id="' + menuid + '_cancel" value="' + canceltxt + '" onclick="mtHide(\'' + menuid + '\')" type="button" />' : '';
    s += '</div>';
    s += '</td></tr></table>';
    $('#' + menuid).html(s);
    if(_(menuid + '_submit')){
        _(menuid + '_submit').onclick = function() {
            if(typeof func == 'function'){
                func();
            }else{
                eval(func);
            }
            mtHide(menuid);
        };
    }
    if(_(menuid + '_cancel')){
        _(menuid + '_cancel').onclick = function() {
            if(typeof funccancel == 'function') funccancel();
            else eval(funccancel);
            mtHide(menuid);
        };
        _(menuid + '_close').onclick = _(menuid + '_cancel').onclick;
    }
    var v = {'menuid':menuid, zindex:900};
    mtMenu(v);
}
var showMsgST = null;
function showMsgbox(msg, mode, func){
    if(_('x-msg-box')) return false;
    clearTimeout(showMsgST);
    if(isUndefined(mode)){
        mode = 'success';
    }
    $('#append_parent').append('<div id="x-msg-box" class="x-msg-box"><div class="x-msg-shadow"></div><div class="x-msg-'+mode+'"><a class="x-msg-icon"></a><div class="x-msg-text">'+msg+'</div></div></div>');
    $('.x-msg-box').animate({'top':0, 'opacity':1},500);
    showMsgST = setTimeout(function(){
        $('#x-msg-box').fadeOut('normal', function(){
            $(this).remove();
            if(typeof func == 'function'){
                func();
            }else if(typeof func != 'undefined'){
                eval(func);
            }
        });
    }, 1000);
}

function mtWindow(k, url) {
    var menuid = 'mt_' + k;
    var menuObj = _(menuid);
    var hidedom = !$.browser.msie ? '<style>object{visibility:hidden;}</style>' : '';

    var fetchContent = function() {
        mtAjx({url:url, type:'get', cache:false}, 'mtbcontent_' + k, function(){show();});
    };
    var show = function() {
        mtHide('mt_dialog');
        mtMenu({'menuid':menuid, zindex:900});
    };
    if(!menuObj) {
        $('#append_parent').append('<div class="mtmenu" id="' + menuid + '" style="display:none;"></div>');
        var m_html = hidedom
            + '<table cellpadding="0" cellspacing="0">'
            + '<tr><td class="bc-ff" id="mtbcontent_' + k + '"></td></tr>'
            + '</table>';
        $('#' + menuid).html(m_html);
        fetchContent();
    } else {
        show();
    }
}
function mtHide(mid){
    $('#' + mid).remove();
    $('#' + mid + '_cover').remove();
}

function mtMenu(v){
    var mtcover = function(){
        var h = Math.max($(document).height(), $(window).height());
        var cr = '<div id="' + v.menuid + '_cover" class="mtcover opy5" style="height: ' + h + 'px;z-index:' + v.zindex + '"></div>';
        $('#append_parent').append(cr);
    };
    mtcover();
    var t = $('#' + v.menuid);
    var top = ($(window).height() - parseInt(t.height()))/3,
        left = ($(window).width()- parseInt(t.width()))/2;
    if(top <0){
        top = 200
    }
    t.css({'z-index':v.zindex+1, top:top+'px', left:left+'px'}).fadeIn(300);
}

var mtdragDisabled = false;
var mtdrag =[];
function mtDrag(menuObj, e, op) {
    e = e ? e : window.event;
    if(op == 1) {
        if(mtdragDisabled) {
            return;
        }
        mtdrag['drag'] = [e.clientX, e.clientY];
        mtdrag['drag'][2] = parseInt(menuObj.style.left);
        mtdrag['drag'][3] = parseInt(menuObj.style.top);
        document.onmousemove = function(e) {try{mtDrag(menuObj, e, 2);}catch(err){}};
        document.onmouseup = function(e) {try{mtDrag(menuObj, e, 3);}catch(err){}};
        mtGc(e);
    }else if(op == 2 && mtdrag['drag'][0]) {
        var exe = [e.clientX, e.clientY];
        menuObj.style.left = (mtdrag['drag'][2] + exe[0] - mtdrag['drag'][0]) + 'px';
        menuObj.style.top = (mtdrag['drag'][3] + exe[1] - mtdrag['drag'][1]) + 'px';
        mtGc(e);
    }else if(op == 3) {
        mtdrag['drag'] = [];
        document.onmousemove = null;
        document.onmouseup = null;
    }
}

function showMenu(dstid, obj){
    var id = _(dstid);
    if(!id) return;
    id.style.display = 'block';
    id.onmouseover = function(){
        this.style.display = 'block';
    };
    id.onmouseout = function(){
        this.style.display = 'none';
    };
    obj.onmouseout =function(){
        id.style.display = 'none';
    };
}

function mtGc(event) {
    var e = event ? event : window.event;
    if(!e){ return null;}
    if(e.preventDefault) {
        e.preventDefault();
    } else {
        e.returnValue = false;
    }
    if(e.stopPropagation) {
        e.stopPropagation();
    } else {
        e.cancelBubble = true;
    }
    return e;
}

function mtAjxPost(formname, showid, waitid, submitid, efunc){
    var form = $('[name=' + formname + ']'),
        url = form.attr('action'),
        data = '';
    form.attr('onsubmit', 'return false');
    $('#' + waitid).html(WAIT).show();
    $('[name=' + formname + '] :input').each(function(){
        var n = $(this).attr('name'), v = $(this).val();
        data += '&' + n + '=' + v;
    });
    data = data.substr(1);
    var mode = {type:'post', url:url, data:data};
    if(isUndefined(efunc)){
        efunc = function (){
            $('#' + submitid).removeAttr('disabled');
            if(showid != waitid){
                $('#' + waitid).html('').hide();
            }
        };
    }
    $('#' + submitid).attr({disabled:'disabled'});
    mtAjx(mode, showid, efunc, -1);
}

function mtAjxChk(url, data, compare){
    var status = false;
    $.ajax({type: 'get', url: url,data: data,cache: false, async:false,error : function(){},success: function(data){if(data == compare){status = true;}}});
    return status;
}

function mtAjx(mode, showid, recall, wait) {
    wait != -1 ? mtLoading() : '';
    $.ajax({
        type: mode.type,
        url: mode.url,
        data: mode.data,
        error : function(){
            wait != -1 ? $('#ajxwaitid').remove() : '';
            $('#' + showid).html(AJAXERROR).hide().show(100);
            if(recall && typeof recall == 'function') {
                recall();
            } else if(recall) {
                eval(recall);
            }
        },
        success: function(data){
            wait != -1 ? $('#ajxwaitid').remove() : '';
            $('#' + showid).html(data).hide().show(100);
            if(recall && typeof recall == 'function'){
                recall(data);
            } else if(recall) {
                eval(recall);
            }
        }
    });
}
function fiximg(obj, box){
    var ih, iw, w = obj.width, h = obj.height;
    if (w > box || h > box) {
        if (w > h) {
            ih = box;
            iw = parseInt((w / h) * box);
            obj.style.marginLeft = '-' + parseInt((iw - ih) / 2) + 'px';
        } else {
            iw = box;
            ih = parseInt((h / w) * box);
            obj.style.marginTop = '-' + parseInt((ih - iw) / 2) + 'px';
        }
    } else {
        iw = w;
        ih = h;
    }
    obj.style.width = iw + 'px';
    obj.style.height = ih + 'px';
    return [w, h];
}
$(function(){
if($.browser.msie && ($.browser.version == "6.0")){redirect('tool/update_your_browser')}
    $('.text').live({focus:function(){var vl=$.trim($(this).val()),dt=$.trim($(this).attr('alt'));if(vl==dt){$(this).val('');}},blur:function(){var vl=$.trim($(this).val()),dt=$.trim($(this).attr('alt'));if(vl==''){$(this).val(dt);}else if(vl==dt){$(this).val('');}}});
    var gotop = 0;
    $(window).scroll(function(){
        if($(window).scrollTop()> 300){
            if(gotop) return;
            $('#scrolltop').fadeIn();
            gotop = 1;
        }else{
            if(!gotop) return;
            $('#scrolltop').fadeOut();
            gotop = 0;
        }
    });
    $('#scrolltop').click(function(){
        $('body,html').animate({scrollTop:'0px'});
    });
    var F_LOGIN = 0;
    $('.heart').click(function(){
        if( ! F_LOGIN){
            if(mtAjxChk('member/check/checklogin', null, '0')){
                mtWindow('login', 'member/login_float?redirect=-1');
                return false;
            }
        }
        F_LOGIN = 1;
        var $this = $(this);
        var imageid = parseInt($this.attr('data-src'));
        mtAjx({type:'get', url:'image/fave_toggle?imageid=' + imageid, cache:false}, '', function(d){
            if(!isUndefined(d)){
                if(d == "1"){
                    $this.addClass('heart-on');
                    showMsgbox('收藏成功', 'success');
                }else if(d == "2"){
                    $this.removeClass('heart-on');
                }else{
                    showMsgbox(d);
                }
            }
        });
        return false;
    });
});