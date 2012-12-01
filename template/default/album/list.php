<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<link href="static/css/album.css" rel="stylesheet" />
<section class="clearfix content w960">
    <article class="content-wrap mt10 pb20">
        <h3 class="fn ml20 mt20 fl"><?php echo ($userinfo->uid && $userinfo->uid == $memberinfo->uid) ? '我' : $memberinfo->username ?>的专辑</h3>
        <ul class="tabs clearfix fr mt20 mr20">
            <li><a href="member/<?php echo $memberinfo->uid?>">图片</a></li>
            <li><a href="member/<?php echo $memberinfo->uid?>/albums" class="act">专辑</a></li>
        </ul>
        <ul id="albumlist" class="pt20 ml20 cb clearfix">
            <?php if(isset($listinfo) && $listinfo !== NULL && $listinfo){foreach($listinfo as $id => $album){?>
            <li>
                <a class="block" href="album/<?php echo $album->albumid?>"><img onload="fiximg(this, 162)" src="<?php echo $album->coverpic?>" alt="<?php echo $album->albumname?>"/></a>
                <div class="album-title">
                    <a id="atag-name" href="album/<?php echo $album->albumid?>"><?php echo $album->albumname?>&nbsp;(<?php echo $album->images?>)</a>
                    <?php if($userinfo->uid && $userinfo->uid == $memberinfo->uid){?>
                    <a class="edit" id="atag-edit" title="编辑" href="album/edit/<?php echo $album->albumid?>">编辑</a>
                    <?php }?>
                </div>
            </li>
            <?php }}?>
        </ul>
        <?php if(isset($page) && $page):?><div class="page pt20"><?php echo $page?></div><?php endif;?>
    </article>
    <aside class="w220 mt10 fr"><?php echo member_modelfield($memberinfo->uid);?></aside>
</section>