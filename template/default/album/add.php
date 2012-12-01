<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<link href="static/css/formValidator.css" rel="stylesheet" />
<section class="clearfix content w960">
    <article class="content-wrap mt10 pb20">
        <h3 class="fn ml20 mt20 pb10"><a class="b" href="member/<?php echo $userinfo->uid?>/albums">我的专辑</a>&nbsp;&raquo;&nbsp;创建专辑</h3>
        <?php echo form_open('album/add',  array('name'=>'addform', 'id'=>'addform'));?>
        <?php echo validation_errors('<div class="pl10 ml20"><span class="c-pink ml60">', '</span></div>'); ?>
        <?php if (isset($error_string)) : echo $error_string; endif;?>
        <div class="inputbox mt10 ml10">
            <label class="w60 fl" for="newalbumname">专辑名称</label>
            <input class="text" id="newalbumname" name="newalbumname" type="text" size="45" value="<?php echo set_value('newalbumname');?>" />
        </div>
        <div class="inputbox mt10 ml10">
            <label class="w60 fl" for="description">专辑描述</label>
            <textarea id="description" name="description" cols="65" rows="6"><?php echo set_value('description');?></textarea>
        </div>
        <div class="inputbox mt10 ml20">
            <input class="btn w50 ml60" id="dosubmit" name="dosubmit" type="submit" value="提交"/>
        </div>
        </form>
    </article>
    <aside class="w220 mt10 fr"><?php echo member_modelfield();?></aside>
</section>
<script src="static/js/formValidator.min.js"></script>
<script type="text/javascript">
$(function(){
    $.formValidator.initConfig({autotip:true,wideword:false,formid:"addform",onerror:function(msg){}});
    $("#newalbumname").formValidator({onshow:"输入专辑名称",onfocus:"专辑名称1到16个字组成"}).inputValidator({min:1,max:16,onerror:"专辑名称1到16个字组成"});
    $('#description').formValidator({onshow:'输入专辑描述', onfocus:'输入专辑描述'}).inputValidator({max:200, onerror:'专辑描述不能超过200字'});
});
</script>