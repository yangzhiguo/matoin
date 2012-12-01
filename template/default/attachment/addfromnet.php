<style type="text/css">
#fetched_image{max-height:190px;max-width:190px;padding:5px;display:none;margin:0 auto}
#imagepreview{width:200px;height:200px}
.cros-nav{background: #FFEBEB;color:#FF7A9C}
.imagepreview{background:#EBEBEB url(static/image/preview.gif) no-repeat center center}
</style>
<div class="w580">
    <h3 ondblclick="mtHide('mt_addfromnet')" onmousedown="mtDrag(_('mt_addfromnet'), event, 1)" class="fn p10 cur-m">
        <a onclick="mtHide('mt_addfromnet')" title="关闭" id="mt_addfromnet_close" href="javascript:void(0);" class="fr close block">关闭</a>
        <span>网络上传</span>
    </h3>
    <div class="p10 cros-nav">
        <p>将<a href="tool" class="b">收藏按钮</a>加在你的网页浏览器上，就可以随时将网页上的收集贴上来。简单又方便~</p>
    </div>
    <div class="p10 clearfix bc-f5">
        <div id="imagepreview" class="fl bc-eb"></div>
        <div class="fr pr">
            <input name="src" id="src" type="text" class="text" value="http://" style="width:340px;" />
            <?php echo album_modelfield($userinfo->uid, 'fromnetform-albumid')?>
            <?php echo form_open('attachment/collect',  array('name'=>'fromnetform', 'id'=>'fromnetform'));?>
            <input id="fromnetform-albumid" type="hidden" name="albumid" value="" />
            <input type="hidden" name="imgurl[]" value="" />
            <input type="hidden" name="fromnet" value="1" />
            <div>
                <textarea  title="添加描述" alt="这里是美图一张" name="desc[]" class="text" style="width:335px;height:60px" >这里是美图一张</textarea>
            </div>
            <input type="submit" class="btn w50 mt10" name="dosubmit" id="dosubmit" onclick="return collect('fromnetform', 'fromnetloading', this.id);" value="发布" disabled="disabled" />
            <span id="fromnetloading" class="pl10"></span>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript" src="static/js/collect.js" ></script>
<script type="text/javascript">
$(function(){
    $('#src').blur(function(){
        var src = $.trim($(this).val());
        if($('#fetched_image').attr('src') == src){
            return;
        }
        if(src.match(/^(http[s]?:\/\/)?([\w-]+\.)+[\w-]+([\w\-\.\/\?!%#&\=]*)?$/)){
            src = $.trim(src);
            if(src.substr(0, 4) != 'http'){
                src = 'http://' + src;
            }
            $('#fetched_image').fadeOut(500).remove();
            $('input[name="imgurl[]"]').val(src);
            $('#imagepreview').html('').addClass('imagepreview');
            $('<img id="fetched_image" src="' + src + '" style="display:none;" onload="this.style.display=\'block\'" />').appendTo('#imagepreview');
            $('#dosubmit').removeAttr('disabled');
        }else{
            $('#imagepreview').html('<div style="line-height:200px;padding-left:5px">无法得到图片，请粘贴图片的网址。</div>');
            $('input[name="imgurl[]"]').val('');
            $('#imagepreview').removeClass('imagepreview');
            $('#dosubmit').attr('disabled');
        }
    }).click(function(){
        $(this).select();
    });
    setTimeout("$('#src').click()", 100);
});
</script>