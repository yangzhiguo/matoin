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
 * @version    $Id login.php v1.0.0 2012-01-10 23:59 $
 */

// ------------------------------------------------------------------------

/**
 * 会员登录模版
 *
 * 登录页面模版
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
    <article class="wrapper mt10 pb20">
        <?php
            echo form_open('member/login',  array('name'=>'loginform', 'id'=>'loginform'));
            echo form_hidden('referrer', $referrer);
        ?>
        <h3 class="p10 ml20 mt10">登录</h3>
        <?php echo validation_errors('<div class="pl10 ml20"><span class="c-pink ml60">', '</span></div>'); ?>
        <?php if (isset($error_string)) : echo '<div class="pl10 ml20"><span class="c-pink ml60">' . $error_string . '</span></div>'; endif;?>
        <div class="inputbox mt10 ml20">
            <label class="w50 fl" for="email">邮箱</label>
            <input type="text" class="text" id="email" name="email" size="50" value="<?php echo set_value('email');?>" />
        </div>
        <div class="inputbox mt10 ml20">
            <label class="w50 fl" for="password">密码</label>
            <input type="password" class="text" id="password" name="password" size="50" value="" />
        </div>
        <div class="inputbox mt10 ml20">
            <input type="submit" class="btn w60 ml60" id="dosubmit" name="dosubmit" value="登录"/>
            <a href="member/getpwd" class="ml20">忘记密码？</a>
        </div>
        <div class="ml20 p10">
            <input class="ml60 cbox" id="remember" name="remember" type="checkbox" value="1"/>
            <label for="remember">记住我的登录状态</label>
        </div>
        <div class="inputbox mt10 ml20">
            <span class="ml60">还没有matoin账户？ </span><a href="member/register">马上注册</a>
        </div>
        </form>
    </article>
</section>
<script type="text/javascript" src="static/js/formValidator.min.js"></script>
<script type="text/javascript" src="static/js/formValidatorRegex.min.js"></script>
<script type="text/javascript">
$(function(){
    $.formValidator.initConfig({autotip:true,wideword:false,formid:"loginform",onerror:function(msg){}});
    $("#email").formValidator({onshow:"请输入邮箱",onfocus:"请输入邮箱",oncorrect:"&nbsp;"}).regexValidator({regexp:"email",datatype:"enum",onerror:"邮箱地址不正确"});
    $("#password").formValidator({onshow:"请输入密码",onfocus:"请输入密码",oncorrect:"&nbsp;"}).inputValidator({min:3,max:16,onerror:"密码应该为3-16位之间"});
});
</script>
<?php
/* End of file login.php */
/* Location: ./template/default/member/login.php */