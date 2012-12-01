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
 * @since      Version ${VERSION} 2012-10-14 上午10:08 $
 * @filesource tag_content.php
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
 * @link        ${FILE_LINK}/tag_content.php
 */
?>
<style type="text/css">
    .p-title{
        float:left;
        width:100%;
    }
    .p-title em{
        font-size: 12px;
        font-weight:normal;
        color: #999;
        padding-left: 5px;
    }
</style>
<section class="content w960 clearfix">
  <h1 class="mt20 p-title"><?php echo $tag_profile['tagname']?><em>共有<?php echo $tag_profile['images']?>个图片</em></h1>
  <article class="wrapper mt20">
    <ul class="clearfix" id="pic-list" style="padding:26px 0 26px 26px">
        <?php if(isset($tag_profile['imageinfo']) && $tag_profile['imageinfo']){foreach($tag_profile['imageinfo'] as $perimage){?>
        <li>
            <div class="fave">
                <a class="heart<?php if(isset($perimage->fave) && $perimage->fave === 1):echo ' heart-on';endif;?>" data-src="<?php echo $perimage->imageid?>"></a>
                <a class="b" href="view/<?php echo $perimage->imageid;?>"><?php echo $perimage->depict;?></a>
                <a href="member/<?php echo $perimage->uid?>"><?php echo $perimage->username;?>&nbsp;发布于<?php echo time_ago($perimage->dateline, TRUE);?></a>
            </div>
            <a href="view/<?php echo $perimage->imageid;?>" title="<?php echo $perimage->depict;?>" class="fave-cover"></a>
            <a href="view/<?php echo $perimage->imageid;?>"><img src="<?php echo read_attachment($perimage->attachment, '_226_188');?>" alt="<?php echo $perimage->depict;?>" /></a>
        </li>
        <?php }}?>
    </ul>
    <?php if(isset($page) && $page):?><div class="page pb20 cb"><?php echo $page?></div><?php endif;?>
  </article>
</section>
<script src="static/js/content.js"></script>
<?php
/* End of file tag_content.php */
/* Location: ${FILE_PATH}/tag_content.php */