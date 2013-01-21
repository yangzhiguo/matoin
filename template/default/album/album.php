<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<link href="static/css/album.css" rel="stylesheet" />
<style type="text/css">
#albumlist li{width:188px;height:188px}
.album-title{width: 178px}
</style>
<section class="clearfix content w960">
    <h3 class="fn mt20 fl">所有专辑</h3>
    <article class="fl mt20 pb20 cb">
        <ul id="albumlist" class="cb clearfix">
            <?php if(isset($listinfo) && $listinfo !== NULL && $listinfo){foreach($listinfo as $id => $album){?>
                <li>
                    <a class="block" href="album/<?php echo $album->albumid?>"><img onload="fiximg(this, 188)" src="<?php echo $album->coverpic?>" alt="<?php echo $album->albumname?>"/></a>
                    <div class="album-title">
                        <a id="atag-name" href="album/<?php echo $album->albumid?>"><?php echo $album->albumname?>&nbsp;(<?php echo $album->images?>)</a>
                    </div>
                </li>
            <?php }}?>
        </ul>
        <?php if(isset($page) && $page):?><div class="page pt20"><?php echo $page?></div><?php endif;?>
    </article>
</section>