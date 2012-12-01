<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * maotin
 *
 * An open source application development framework for PHP 5.3 or newer
 *
 * @package    ${PACKAGE_NAME}
 * @author     <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2010 - 2012, Yzg, Inc.
 * @license    ${LICENSE_LINK}
 * @link       ${PROJECT_LINK}
 * @since      Version ${VERSION} 2012-10-25 下午1:19 $
 * @filesource getpwd.php
 */

// ------------------------------------------------------------------------
?>
<section class="clearfix content w960">
    <article class="wrapper mt10">
        <div class="p20">
            <h3 class="pl10">找回密码</h3>
            <p class="p10">请输入你注册时填写的Email，我们会发送密码重置url到你的邮箱！</p>
            <?php
            echo form_open('member/getpwd',  array('name'=>'getpwd', 'id'=>'getpwd'));
            echo validation_errors('<div class="m10"><span class="c-pink ml60">', '</span></div>');
            if (isset($error_string)) : echo '<div class="m10">' . $error_string . '</div>'; endif;
            ?>
                <div class="inputbox mt20">
                    <label class="w50 fl" for="email">邮箱</label>
                    <input type="text" class="text" id="email" name="email" size="50" value="<?php echo set_value('email');?>" />
                    <input type="submit" class="btn w60 ml10" id="dosubmit" name="dosubmit" value="发送"/>
                </div>
            </form>
        </div>
    </article>
</section>