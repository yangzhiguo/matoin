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
 * @since      Version ${VERSION} 2012-10-13 下午9:36 $
 * @filesource tag.php
 */

// ------------------------------------------------------------------------

/**
 * ${CLASS_NAME}
 *
 * ${CLASS_DESCRIPTION}
 *
 * @package     ${PACKAGE_NAME}
 * @subpackage  ${SUBPACKAGE_NAME}
 * @category    ${CATEGORY_NAME}
 * @author      <yangzhiguo0903@gmail.com>
 * @link        ${FILE_LINK}/tag.php
 */

?>
<style type="text/css">
    .tag-list li{
        padding: 0 10px 10px 0;
        float: left;
    }
    .tag-list a{
        display: block;
        border-radius:20px;
        background: #FFF;
        color: #333;
        border:1px solid #DDD;
        padding: 4px 12px;
    }
    .tag-list a:hover{
        background:#F1EFE9;
        border-color: #C9C9C9;
    }
</style>
<section class="content w960 clearfix">
    <h1 class="mt20 fl wf100">所有标签</h1>
    <ul class="mt20 fl tag-list clearfix">
    <?php if(isset($tag)){foreach($tag as $tt){?>
        <li><a href="tag/<?php echo $tt->tagid?>"><?php echo $tt->tagname?></a></li>
    <?php }}?>
    </ul>
    <?php if(isset($page) && $page):?><div class="page pt20 cb"><?php echo $page?></div><?php endif;?>
</section>
<?php

/* End of file tag.php */
/* Location: ${FILE_PATH}/tag.php */