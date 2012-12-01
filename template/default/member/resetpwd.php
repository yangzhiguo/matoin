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
 * @since      Version ${VERSION} 2012-10-29 下午3:00 $
 * @filesource resetpwd.php
 */

// ------------------------------------------------------------------------
?>
<section class="clearfix content w960">
    <article class="wrapper mt10">
        <div class="p20">
            <h3 class="pl10 pb10">重设密码</h3>
            <?php
            echo form_open(current_url(),  array('name'=>'resetpwd', 'id'=>'resetpwd'));
            echo validation_errors('<div class="m10"><span class="c-pink ml60">', '</span></div>');
            if (isset($error_string)) : echo $error_string; endif;
            ?>
            <div class="inputbox mt10">
                <label class="w50 fl" for="password">密码</label>
                <input type="password" class="text" id="password" name="password" size="50" value="" />
            </div>
            <div class="inputbox mt10">
                <label class="w50 fl" for="passconf">重复密码</label>
                <input type="password" class="text" id="passconf" name="passconf" size="50" value="" />
            </div>
            <div class="inputbox mt10">
                <input type="submit" class="btn w60 ml60" id="dosubmit" name="dosubmit" value="确认">
            </div>
            </form>
        </div>
    </article>
</section>