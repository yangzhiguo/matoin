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
 * @version    $Id pwd.php v1.0.0 2012-01-14 22:46 $
 */

// ------------------------------------------------------------------------

/**
 * 会员中心修改密码模版
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
                <li><a href="member/setting">基本设置</a></li>
                <li><a href="member/avatar" >修改头像</a></li>
                <li><a class="act" href="member/pwd">更改密码</a></li>
            </ul>
        </div>
        <?php echo form_open('member/pwd',  array('name'=>'pwdform', 'id'=>'pwdform'));?>
        <?php echo validation_errors('<div class="pl10 ml20"><span class="c-pink ml60">', '</span></div>'); ?>
        <?php if (isset($error_string)) : echo $error_string; endif;?>
        <div class="inputbox mt10 ml10">
            <label class="w60 fl" for="password">当前密码</label>
            <input class="text" id="password" name="password" type="password" size="45" value="<?php echo set_value('city')?>" />
        </div>
        <div class="inputbox mt10 ml10">
            <label class="w60 fl" for="newpassword">新密码</label>
            <input class="text" id="newpassword" name="newpassword" type="password" size="45" value="<?php echo set_value('siteurl')?>" />
        </div>
        <div class="inputbox mt10 ml20">
            <input class="btn w50 ml60" id="dosubmit" name="dosubmit" type="submit" value="更新"/>
        </div>
        </form>
    </article>
    <aside class="w220 mt10 fr"><?php echo member_modelfield();?></aside>
</section>
<script type="text/javascript" src="static/js/formValidator.min.js"></script>
<script type="text/javascript">
$(function(){
    $.formValidator.initConfig({autotip:true,wideword:false,formid:"pwdform",onerror:function(msg){}});
    $("#password").formValidator({onshow:"请输入当前密码",onfocus:"请输入当前密码",oncorrect:"&nbsp;"}).inputValidator({min:3,max:16,onerror:"密码应该为3-16位之间"});
    $("#newpassword").formValidator({onshow:"请输入新密码",onfocus:"请输入新密码",oncorrect:"&nbsp;"}).inputValidator({min:3,max:16,onerror:"新密码应该为3-16位之间"});
});
</script>
<?php
/* End of file pwd.php */
/* Location: ./template/member/pwd.php */