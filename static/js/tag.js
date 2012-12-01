function addtag(imageid){
    var tag = $.trim($('input[name="tag"]').val());
    if(tag == '' || tag == '多个标签使用逗号隔开'){
        $('input[name="tag"]').focus();
        return false;
    }
    mtAjxPost('addtagform', '', '', null, function(d){
        if(!isUndefined(d) && !(d <0)){
            var d = eval(d);
            for(var i in d){
                $('<li><a href="tag/' + d[i].id + '" class="tg-grey">' + d[i].tag + '<span class="deletetag" onclick="deletetag(' + d[i].id + ',' + imageid + ',this);return false;">x</span></a></li>').appendTo($('#taglist'));
            }
            $('#notag').remove();
            $('#add-tag-ctrl').remove().appendTo($('#taglist'));
            $('input[name="tag"]').val('');
        }
    });
}
function deletetag(tagid, itemid, obj){
    mtAjx({type:'get', url:'tag/delete/' + tagid + '/' + itemid, cache:false}, '', function(d){
        if(d == '1'){
            var x = $(obj).parent();
            x.fadeOut('fast', function(){x.remove()});
        }
    });
}
function inserttag(obj){
    var ntg = [];
    var apd = $.trim($(obj).text()).replace(/(，|,)/, '');
    var old = $('input[name="tag"]').val();
    old = explode('，', old.replace(/(，|,)/, '，'));
    for(var i in old){
        if(apd == old[i]){
            return;
        }
        if(old[i] != '' && old[i] != '多个标签使用逗号隔开'){
            ntg.push(old[i]);
        }
    }
    ntg.push(apd);
    $('input[name="tag"]').val(ntg.join('，'));
}
function toggletagbox(obj){
    $('#add-tag-form').slideToggle(100, function(){
        var $this = $(obj);
        if($this.text() == '+'){
            $this.text('-');
        }else{
            $this.text('+');
        }
    });
}