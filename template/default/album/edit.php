<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<link href="static/css/formValidator.css" rel="stylesheet" />
<section class="clearfix content w960">
    <article class="content-wrap mt10 pb20">
        <h3 class="fn ml20 mt20 pb10"><a class="b" href="member/<?php echo $userinfo->uid?>/albums">我的专辑</a>&nbsp;&raquo;&nbsp;<?php echo $albuminfo->albumname;?></h3>
        <?php echo form_open('album/edit/' . $albuminfo->albumid,  array('name'=>'editform', 'id'=>'editform'));?>
        <?php echo validation_errors('<div class="pl10 ml20"><span class="c-pink ml60">', '</span></div>'); ?>
        <?php if (isset($error_string)) : echo $error_string; endif;?>
        <div class="inputbox mt10 ml10">
            <label class="w60 fl" for="name">专辑名</label>
            <input class="text" id="name" name="name" type="text" size="45" value="<?php echo $albuminfo->albumname;?>" />
        </div>
        <div class="inputbox mt10 ml10">
            <label class="w60 fl" for="depict">专辑描述</label>
            <textarea id="depict" name="depict" cols="65" rows="6"><?php echo $albuminfo->depict;?></textarea>
        </div>
        <div class="inputbox mt10 ml20">
            <input class="btn w50 ml60" id="dosubmit" name="dosubmit" type="submit" value="更新"/>
            <a class="ml20" id="delete_album_button" href="javascript:void(0);" onclick="delete_album(<?php echo $albuminfo->albumid?>, <?php echo $userinfo->uid?>);">删除</a>
        </div>
        </form>
    </article>
    <aside class="w220 mt10 fr"><?php echo member_modelfield()?></aside>
</section>
<script src="static/js/formValidator.min.js"></script>
<script type="text/javascript">
function delete_album(albumid, uid){
    var delete_album_after = function (data){
        if(data == 1){
            showMsgbox('删除成功', 'success', function(){redirect('member/' + uid + '/albums');})
        }else{
            showMsgbox('删除专辑失败', 'error');
        }
    };
    showDialog('你确定要删除这个专辑？','confirm','',function(){mtAjx({type:'get', url:'album/delete/' + albumid, cache:false}, '', delete_album_after)},null,'专辑中的图片不会被删除。');
}
$(function(){
    $.formValidator.initConfig({autotip:true,wideword:false,formid:"editform",onerror:function(msg){}});
    $("#name").formValidator({onshow:"输入专辑名称",onfocus:"专辑名称1到16个字组成"}).inputValidator({min:1,max:16,onerror:"专辑名称1到16个字组成"});
    $('#depict').formValidator({onshow:'输入专辑描述', onfocus:'输入专辑描述'}).inputValidator({max:200, onerror:'专辑描述不能超过200字'});
});
</script>