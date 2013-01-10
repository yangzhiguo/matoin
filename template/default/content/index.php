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
 * @version    $Id index.php v1.0.0 2012-01-10 21:33 $
 */

// ------------------------------------------------------------------------

/**
 * 内容模版
 *
 * 首页模版
 *
 * @package     matoin
 * @subpackage  Template
 * @category    Front-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
?>
<section class="content w960 clearfix">
    <?php if(!($userinfo->uid> 0)){?><nav class="wrapper mt10">
        <div class="wf-68 clearfix" style="margin:0 auto;padding:10px 0;text-align:center">
            <p class="fl" style="line-height:32px;">在猫头鹰，你可以1.收藏你喜欢的图片。2.创建自己的专辑。3.和热爱清新的朋友畅聊。</p>
            <a class="fr btn w100 pl10 pr10" href="member/register">开始猫头鹰之旅</a>
        </div>
    </nav><?php }?>
    <?php if(isset($hot) && $hot){?><h1 class="mt20 fl wf100">热门图片</h1><?php }?>
    <article class="wrapper mt10">
        <ul class="clearfix" id="pic-list" style="padding:26px 0 26px 26px">
            <?php if(isset($imagelist) && $imagelist){foreach($imagelist as $perimage){?>
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
        </ul><!-- #pic-list-->
        <?php if(isset($page) && $page):?><div class="page pb20"><?php echo $page?></div><?php endif;?><!-- .page -->
    </article>
</section>
<script src="static/js/content.js"></script>
<?php
/* End of file index.php */
/* Location: ./template/content/index.php */