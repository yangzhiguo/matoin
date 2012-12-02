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
 * @version    $Id guide.php v1.0.0 2012-01-14 22:46 $
 */

// ------------------------------------------------------------------------

/**
 * 注册向导页面
 *
 * @package     matoin
 * @subpackage  Template
 * @category    Front-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
?>
<section class="clearfix content w960">
    <article class="wrapper mt10">
        <div class="p20 ml10">
            <h3>查收确认信</h3>
            <p>确认信已发到你的邮箱<?php echo $email?>，请登录邮箱并点击邮件中的确认链接来完成注册。</p>
            <h3 class="mt20">还没有收到确认信？</h3>
            <ul>
                <li>看一下所填写的email地址是否正确，错了就重新注册一次吧:)；</li>
                <li>看看是否在邮箱的垃圾箱里；</li>
                <li>稍等几分钟，若依旧没收到确认信，<a href="javascript:void(0);" onclick='return sendmailagain("<?php echo $uri?>");' class="b">点此重发验证邮件</a>。</li>
            </ul>
        </div>
    </article>
</section>
<script type="text/javascript" src="static/js/mail.js"></script>