<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Maotin System
 *
 * 猫头鹰Maotin - 帮你寻找最有价值的东西
 *
 * Maotin - to help you find the most valuable thing
 *
 * @package    Maotin
 * @author     yzg <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2011 - 2012, maotin.com.
 * @license    GNU General Public License 2.0
 * @link       http://www.maotin.com/
 * @version    $Id login_float.php v1.0.0 2012-01-02 10:28 $
 */

// ------------------------------------------------------------------------

/**
 * login_float.php模版
 *
 * 浮动登录框
 *
 * @package     Maotin
 * @subpackage  Template
 * @category    Front-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */
?>
<div class="w480 pr" style="height: 220px;">
    <div class="fl wf-68">
        <?php
            echo form_open('member/login',  array('name'=>'loginfloatform', 'id'=>'loginfloatform'));
            echo form_hidden('ajx', '1');
            echo form_hidden('referrer', $referrer);
            echo form_hidden('redirect', $redirect);
        ?>
        <h3 class="fn p10 cur-m" onmousedown="mtDrag(_('mt_login'), event, 1)">登录</h3>
        <div class="ml10 mr10 c-pink" id="mt_login_loading"></div>
        <div class="inputbox bc-f5 mt10 ml10 mr10">
            <label class="fl" for="email">邮箱</label>
            <input type="text" class="text" id="email" name="email" size="35" value="" />
        </div>
        <div class="inputbox bc-f5 mt10 ml10 mr10">
            <label class="fl" for="password">密码</label>
            <input type="password" class="text" id="password" name="password" size="35" value="" />
        </div>
        <div class="inputbox fr mt5 ml10 mr10">
            <a href="member/getpwd" class="mr10">忘记密码？</a>
            <input type="submit" class="btn w50" id="dosubmit" name="dosubmit" onclick="return dologinfloat();" value="登录"/>
        </div>
        </form>
    </div>
    <div class="fr wf-32 bc-eb hf100">
        <div class="pa" style="bottom: 13px; right:25px;">
            <p class="pb5">还没有Maotin帐户？</p>
            <input class="btn w100" value="立即注册" type="button" onclick="redirect('member/register');" />
        </div>
        <a class="fr mr5 mt5 close" title="关闭" href="javascript:void(0);" onclick="mtHide('mt_login')">关闭</a>
    </div>
</div>
<script type="text/javascript">
$(function(){setTimeout("$('#email').focus()", 100);});
function dologinfloat()
{
    var email = $.trim($('#email').val());
    var pwd   = $.trim($('#password').val());
    if(email == ''){
        $('#mt_login_loading').html('<div>请输入邮箱地址</div>').hide().show(100);
        return false;
    }
    if(pwd == ''){
        $('#mt_login_loading').html('<div>请输入密码</div>').hide().show(100);
        return false;
    }
    if(!checkemail(email)){
        $('#mt_login_loading').html('<div>邮箱格式不正确</div>').hide().show(100);
        return false;
    }
    if((strlen(pwd) <3 || strlen(pwd)> 16)){
        $('#mt_login_loading').html('<div>密码长度为3-16位</div>').hide().show(100);
        return false;
    }
    var oldWAIT = WAIT;
    WAIT = '<img src=\'static/image/preview.gif\' alt=\'登录中...\' />';
    mtAjxPost('loginfloatform', 'mt_login_loading', 'mt_login_loading', 'dosubmit');
    WAIT = oldWAIT;
    return false;
}
</script>