<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Maotin System
 *
 * 猫头鹰Maotin - 寻找最有价值的东西
 *
 * Maotin - to help you find the most valuable thing
 *
 * @package    Maotin
 * @author     yzg <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2011 - 2012, maotin.com.
 * @license    GNU General Public License 2.0
 * @link       http://www.maotin.com/
 * @version    $Id wide.php v1.0.0 2012-01-10 23:04 $
 */

// ------------------------------------------------------------------------

/**
 * 收藏工具模版
 *
 *
 * @package     Maotin
 * @subpackage  Template
 * @category    Front-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */
?>
<section class="content w960 clearfix">
    <article class="wrapper mt10 pb20">
        <div class="p20"><?php if(!empty($active)){?>
            <h3 class="b tc p20">账户激活成功，使用分享工具，可以轻松将你喜欢的图片保存到猫头鹰</h3><?php }?>
            <h3 class="mb10">收藏工具</h3>
            <p class="p20 bc-f5">使用收藏工具，无需上传图片，即可将你所喜欢的图片及链接地址保存到猫头鹰，仅需3秒！</p>
            <h3 class="mt20 mb10">第一步，安装书签栏采集工具：</h3>
            <p class="p20 bc-f5">把这个按钮拖到你的浏览器书签栏&nbsp;&rsaquo;&rsaquo;&rsaquo;&nbsp;<a class="btn w75 pl15" style="cursor:move" title="❤ 猫头鹰" href="javascript:void((function(){var f=document.createElement('script');f.type='text/javascript';f.charset='utf-8';f.src='<?php echo site_url("static/js/tool.js");?>';document.body.appendChild(f);})());">❤ 猫头鹰</a></p>
            <p class="pt10"><img src="static/image/tool/add.png" alt="拖到浏览器书签栏" /></p>
            <h3 class="pt10">第二步，使用方法：</h3>
            <p class="p20 bc-f5">浏览其他页面时看到自己喜欢的图片，点击书签栏里的“❤ 猫头鹰”按钮，即可将它保存到猫头鹰。</p>
            <p class="pt10"><img src="static/image/tool/use.png" alt="点击书签栏里的“❤ 猫头鹰”按钮，即可将它保存到猫头鹰。" /></p>
            <h3 class="pt10">还是搞不定？</h3>
            <div>
                <p>亲，把问题反馈给我，我来帮你搞定！你可以：</p>
                <p>1. 给我admin@maotin.com发邮件或者加入QQ群：<span class="b">230243937</span>，告诉我你遇到了什么问题，我会帮你解决。</p>
                <p>2. 要不你换个浏览器吧。比如<a target="_blank" href="http://www.google.com/chrome/">Chrome</a>，<a target="_blank" href="http://firefox.com.cn/">Firefox</a></p>
            </div>
        </div>
    </article>
</section>
<?php
/* End of file index.php */
/* Location: ./template/content/index.php */