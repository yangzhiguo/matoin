<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * matoin
 *
 * An open source application development framework for PHP 5.3 or newer
 *
 * @package    ${PACKAGE_NAME}
 * @author     <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2010 - 2012, Yzg, Inc.
 * @license    ${LICENSE_LINK}
 * @link       ${PROJECT_LINK}
 * @since      Version ${VERSION} 2012-10-24 上午11:47 $
 * @filesource thinbody.php
 */

// ------------------------------------------------------------------------
?>
<section class="clearfix content w960">
    <article class="wrapper mt10">
        <div class="p20 ml10">
            <h3 class="mb10">邮箱验证失败</h3>
            <p><a href="javascript:void(0);" onclick='return sendmailagain("<?php echo $uri?>");' class="b">点此重发验证邮件</a></p>
        </div>
    </article>
</section>
<script type="text/javascript" src="static/js/mail.js"></script>