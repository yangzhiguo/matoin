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
 * @version    $Id home.php v1.0.0 2012-01-14 22:46 $
 */

// ------------------------------------------------------------------------

/**
 * 会员中心主页
 *
 * @package     Maotin
 * @subpackage  Template
 * @category    Front-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */
?>

<section class="clearfix content w960">
    <article class="content-wrap mt10 pb20">
        <h3 class="fn ml20 mt20 fl"><?php echo $memberinfo->uid == $userinfo->uid ? '我' : $memberinfo->username?>喜欢的图片</h3>
        <ul class="tabs clearfix fr mt20 mr20">
            <li><a href="member/<?php echo $memberinfo->uid?>" class="act">图片</a></li>
            <li><a href="member/<?php echo $memberinfo->uid?>/albums">专辑</a></li>
        </ul>
        <ul class="pt20 ml20 clearfix cb" id="pic-list">
            <?php if( ! empty($piclist)){foreach($piclist as $picid => $picprofile){?>
            <li>
                <div class="fave">
                    <a class="heart<?php if($picprofile->fave === 1):echo ' heart-on';endif;?>" data-src="<?php echo $picprofile->imageid;?>"></a>
                    <a class="b" href="view/<?php echo $picprofile->imageid;?>"><?php echo $picprofile->depict;?></a>
                    <a href="member/<?php echo $picprofile->uid?>"><?php echo $picprofile->username;?>&nbsp;发布于<?php echo time_ago($picprofile->dateline, TRUE);?></a>
                </div>
                <a href="view/<?php echo $picprofile->imageid;?>" title="<?php echo $picprofile->depict;?>" class="fave-cover"></a>
                <a href="view/<?php echo $picprofile->imageid?>"><img alt="<?php echo $picprofile->depict?>" title="<?php echo $picprofile->depict?>" width="226" style="display: block;" src="<?php echo read_attachment($picprofile->attachment, '_226_188')?>" /></a>
            </li>
            <?php }}?>
        </ul>
        <?php if(isset($page) && $page):?><div class="page pt20"><?php echo $page?></div><?php endif;?>
    </article>
    <aside class="w220 mt10 fr"><?php echo member_modelfield($memberinfo->uid);?><a href="javascript:void(0);" id="scrolltop" class="tg-green">返回顶部</a></aside>
</section>
<script type="text/javascript" src="static/js/content.js"></script>
<?php
/* End of file home.php */
/* Location: ./template/member/home.php */