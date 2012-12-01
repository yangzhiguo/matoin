<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ${PROJECT_NAME}
 *
 * An open source application development framework for PHP 5.3 or newer
 *
 * @package    ${PACKAGE_NAME}
 * @author     <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2010 - 2012, Yzg, Inc.
 * @license    ${LICENSE_LINK}
 * @link       ${PROJECT_LINK}
 * @since      Version ${VERSION}
 * @filesource album_contents.php
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
 * @link        ${FILE_LINK}/album_contents.php
 */

?>
<style type="text/css">
#albuminfo-wrap{background:#FFF;padding:10px;position:fixed;width:200px}
</style>
<section class="clearfix content w960">
    <article class="content-wrap mt10 pb20">
        <h3 class="fn ml20 mt20"><a class="b" href="member/<?php echo $albuminfo->uid?>/albums"><?php echo $albuminfo->uid == $userinfo->uid ? '我' : $albuminfo->username?>的专辑</a>&nbsp;&raquo;&nbsp;<?php echo $albuminfo->albumname?></h3>
        <ul id="pic-list" class="clearfix ml20 mt20">
<?php if( ! empty($piclist)){foreach($piclist as $picid => $picprofile){?>
            <li>
                <div class="fave">
                    <a class="heart<?php if($picprofile->fave === 1):echo ' heart-on';endif;?>" data-src="<?php echo $picprofile->imageid?>"></a>
                    <a class="b" href="view/<?php echo $picprofile->imageid;?>"><?php echo $picprofile->depict;?></a><a href="member/<?php echo $albuminfo->uid?>"><?php echo $albuminfo->username;?>&nbsp;发布于<?php echo time_ago($picprofile->dateline, TRUE);?></a>
                    <?php if($albuminfo->uid == $userinfo->uid){?><a href="javascript:void(0);" title="点击设置为封面" onclick="return set_album_cover(<?php echo $picprofile->imageid;?>,<?php echo $albuminfo->albumid;?>);">设为封面</a><?php }?>
                </div>
                <a href="view/<?php echo $picprofile->imageid;?>" title="<?php echo $picprofile->depict;?>" class="fave-cover"></a>
                <a href="view/<?php echo $picprofile->imageid?>"><img alt="<?php echo $picprofile->depict?>" title="<?php echo $picprofile->depict?>" width="226" src="<?php echo read_attachment($picprofile->attachment, '_226_188')?>" /></a>
            </li>
<?php }}?>
        </ul>
        <?php if(isset($page) && $page):?><div class="page pt20"><?php echo $page?></div><?php endif;?>
    </article>
    <aside class="w220 mt10 fr">
        <div class="sd" id="albuminfo-wrap">
            <a href="member/<?php echo $albuminfo->uid?>/albums" class="mt5 tg-green">返回该用户专辑首页</a>
            <div class="mt20 clearfix pr">
                <div style="width:200px;height:150px;overflow:hidden">
                    <img class="block" onload="fiximg(this, 200)" title="<?php echo $albuminfo->albumname?>封面" src="<?php echo $albuminfo->coverpic?>" alt="<?php echo $albuminfo->albumname?>" />
                </div>
            </div>
            <p class="mt10"><a class="b" href="member/<?php echo $albuminfo->uid?>"><?php echo $albuminfo->username?></a>&nbsp;创建于<?php echo time_ago($albuminfo->dateline)?></p>
            <p class="mt10"><?php echo $albuminfo->depict?></p>
        </div>
        <a href="javascript:void(0);" id="scrolltop" class="tg-green">返回顶部</a>
    </aside>
</section>
<script type="text/javascript" src="static/js/content.js"></script>
<script type="text/javascript">
function set_album_cover(imageid, albumid){
    mtAjx({type:'get', url:'album/setcover?albumid=' + albumid + '&imageid=' + imageid, cache:false}, '', function(d){
        if(!isUndefined(d) && d == '1'){
            showMsgbox('设置专辑封面成功', 'success', function(){window.location.reload()});
        }else{
            showMsgbox('设置专辑封面失败', 'error');
        }
    });
}
</script>
<?php

// END ${CLASS_NAME} class

/* End of file album_contents.php */
/* Location: ${FILE_PATH}/album_contents.php */
