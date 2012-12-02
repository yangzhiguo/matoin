<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * matoin System
 *
 * 猫头鹰matoin - 寻找最有价值的东西
 *
 * matoin - to help you find the most valuable thing
 *
 * @package    matoin
 * @author     yzg <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2011 - 2012, matoin.com.
 * @license    GNU General Public License 2.0
 * @link       http://www.matoin.com/
 * @version    $Id setting.php v1.0.0 2012-01-14 22:46 $
 */

// ------------------------------------------------------------------------

/**
 * 会员中心设置
 *
 * @package     matoin
 * @subpackage  Template
 * @category    Front-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
?>
<link href="static/css/formValidator.css" rel="stylesheet" />
<section class="clearfix content w960">
    <article class="content-wrap mt10 pb20">
        <div class="clearfix pb10">
            <h3 class="mt20 ml20 fl fn">设置</h3>
            <ul class="mt20 mr20 fr clearfix tabs">
                <li><a class="act" href="member/setting">基本设置</a></li>
                <li><a href="member/avatar" >修改头像</a></li>
                <li><a href="member/pwd">更改密码</a></li>
            </ul>
        </div>
        <?php echo form_open('member/setting',  array('name'=>'settingform', 'id'=>'settingform'));?>
        <?php echo validation_errors('<div class="ml20"><span class="c-pink ml60">', '</span></div>'); ?>
        <?php if (isset($error_string)) : echo $error_string; endif;?>
        <div class="clearfix inputbox mt10 ml10">
            <label class="w50 fl">邮箱</label>
            <label class="fl"><?php echo $userinfo->email;?></label>
        </div>
        <div class="clearfix inputbox mt10 ml10 cb">
            <label class="w50 fl">用户名</label>
            <label class="fl"><input class="text" id="username" name="username" type="text" size="45" value="<?php echo set_value('username') ? set_value('username') : $userinfo->username;?>" /></label>
        </div>
        <div class="inputbox mt10 ml10">
            <label class="w50 fl" for="city">城市</label>
            <input class="text" id="city" name="city" type="text" size="45" value="<?php echo set_value('city') ? set_value('city') : $profile->city?>" />
        </div>
        <div class="inputbox mt10 ml10">
            <label class="w50 fl" for="siteurl">主页</label>
            <input class="text" id="siteurl" name="siteurl" type="text" size="45" value="<?php echo set_value('siteurl') ? set_value('siteurl') : $profile->siteurl?>" />
        </div>
        <div class="inputbox mt10 ml10">
            <label class="w50 fl" for="signature">签名</label>
            <textarea id="signature" name="signature" cols="65" rows="6"><?php echo set_value('signature') ? set_value('signature') : $profile->signature?></textarea>
        </div>
        <div class="inputbox mt10 ml10">
            <input class="btn w50 ml60" id="dosubmit" name="dosubmit" type="submit" value="更新"/>
        </div>
        </form>
    </article>
    <aside class="w220 mt10 fr"><?php echo member_modelfield();?></aside>
</section>
<script type="text/javascript" src="static/js/formValidator.min.js"></script>
<script type="text/javascript" src="static/js/formValidatorRegex.min.js"></script>
<script type="text/javascript">
$(function(){
    $.formValidator.initConfig({autotip:true,wideword:false,formid:"settingform",onerror:function(msg){}});
    $('#username').formValidator({onshow:"输入用户名", onfocus:"用户名由3到16个字符组成"}).inputValidator({min:3,max:16,onerror:"用户名由3到16个字符组成"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"用户名只能为中文、字母、数字和下划线"}).ajaxValidator({type:"get",url:"member/check/checkusername",datatype:"html",async:'false',success : function(data){return data == "1"},buttons: $("#dosubmit"),onerror : "用户名已存在",onwait : "请稍候..."}).defaultPassed();
    $('#city').formValidator({onshow:"输入居住地所在城市", onfocus:"输入居住地所在城市",empty:true}).inputValidator({max:80,onerror:"城市名太长了"}).regexValidator({regexp:"chinese",datatype:"enum",onerror:"城市名只能为中文"}).defaultPassed();
    $('#siteurl').formValidator({onshow:"输入个人主页地址", onfocus:"输入个人主页地址",empty:true}).inputValidator({max:120,onerror:"个人主页地址太长了"}).regexValidator({regexp:"url",datatype:"enum",onerror:"个人主页地址格式不正确"}).defaultPassed();
    $('#signature').formValidator({onfocus:"写几句简单的个性签名吧",empty:true}).inputValidator({max:200,onerror:"个性签名不能超过200字"}).defaultPassed();
});
</script>
<?php
/* End of file setting.php */
/* Location: ./template/member/setting.php */