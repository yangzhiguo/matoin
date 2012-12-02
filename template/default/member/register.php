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
 * @version    $Id register.php v1.0.0 2012-01-12 22:04 $
 */

// ------------------------------------------------------------------------

/**
 * 会员注册模版
 *
 * 注册页面模版
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
            echo form_open('member/register',  array('name'=>'registerform', 'id'=>'registerform'));
            echo form_hidden('referrer', $referrer);
        ?>
            <h3 class="p10 ml20 mt10">注册</h3>
            <?php echo validation_errors('<div class="pl10 ml20"><span class="c-pink ml60">', '</span></div>'); ?>
            <div class="inputbox mt10 ml20">
                <label class="w50 fl" for="email">邮箱</label>
                <input class="text" id="email" name="email" type="text" size="50" value="<?php echo set_value('email'); ?>" />
            </div>
            <div class="inputbox mt10 ml20">
                <label class="w50 fl" for="username">用户名</label>
                <input class="text" id="username" name="username" type="text" size="50" value="<?php echo set_value('username'); ?>" />
            </div>
            <div class="inputbox mt10 ml20">
                <label class="w50 fl" for="password">密码</label>
                <input class="text" id="password" name="password" type="password" size="50" value="" />
            </div>
            <div class="inputbox mt10 ml20">
                <input class="btn w100 ml60" id="dosubmit" name="dosubmit" type="submit" value="立即注册"/>
            </div>
            <div class="inputbox mt10 ml20 mb20">
                <span class="ml60">点击注册即表示已阅读并同意</span><a href="#">《猫头鹰用户使用协议》</a>
            </div>
            <div class="inputbox mt10 ml20">
                <span class="ml60">已经有账户？ </span><a href="member/login">现在登录</a>
            </div>
        </form>
    </article>
</section>
<script src="static/js/formValidator.min.js"></script>
<script src="static/js/formValidatorRegex.min.js"></script>
<script type="text/javascript">
$(function(){
    $.formValidator.initConfig({autotip:true,wideword:false,formid:"registerform",onerror:function(msg){}});
    $("#email").formValidator({onshow:"输入常用邮箱",onfocus:"输入常用邮箱",oncorrect:"邮箱可以使用"}).regexValidator({regexp:"email",datatype:"enum",onerror:"邮箱格式错误"}).ajaxValidator({url:"member/check/checkemail",datatype:"html",async:'false',success:function(data){return data == "1"},buttons:$("#dosubmit"),onerror:"哎呀，邮箱已经被注册了",onwait:"请稍候..."});
    $('#username').formValidator({onshow:"输入用户名", onfocus:"用户名由3到16个字符组成"}).inputValidator({min:3,max:16,onerror:"用户名由3到16个字符组成"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"用户名只能为中文、字母、数字和下划线"}).ajaxValidator({url:"member/check/checkusername",datatype:"html",async:'false',success : function(data){return data == "1"},buttons: $("#dosubmit"),onerror : "用户名已存在",onwait : "请稍候..."});
    $("#password").formValidator({onshow:"输入密码",onfocus:"密码由3到16个字符组成"}).inputValidator({min:3,max:16,onerror:"密码由3到16个字符组成"}).regexValidator({regexp:"notempty",datatype:"enum",onerror:"密码不能包含空格"});
});
</script>
<?php
/* End of file register.php */
/* Location: ./template/default/member/register.php */