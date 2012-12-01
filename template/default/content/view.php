<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: yangzhiguo
 * Date: 12-2-9
 * Time: 下午7:39
 * To change this template use File | Settings | File Templates.
 */
?>
<section class="content w960 clearfix">
    <article class="bc-ff fl mt10 sd w580">
        <h3 class="fn" id="image-depict"><?php echo $imageinfo->depict?></h3>
        <div class="clearfix pt20 pr20 pl20">
            <a class="fl" href="member/<?php echo $imageinfo->uid?>"><img class="block" alt="" src="<?php echo avatar_uri($imageinfo->uid, 'small')?>" /></a>
            <div class="fl ml10">
                <p><a href="member/<?php echo $imageinfo->uid?>" class="b"><?php echo $imageinfo->username?></a>&nbsp;发布于&nbsp;<?php echo time_ago($imageinfo->dateline)?></p>
            </div>
            <a class="heart<?php if($imageinfo->fave === 1):echo ' heart-on';endif;?> fr" data-src="<?php echo $imageinfo->imageid?>"></a>
        </div>
        <div class="p20 tc">
            <img alt="" style="max-width:540px;display:block;margin:0 auto" src="<?php echo $imageinfo->attachment?>" />
        </div>
        <div class="p20" id="pic-comment">
            <div class="comm-list">
                <ul id="comm-ul">
                    <?php if($imageinfo->commenttimes> 0):?><li>评论加载中...</li><?php endif;?>
                </ul>
            </div>
            <div class="pr mb10 mt10 clearfix">
<?php
if (isset($userinfo) && $userinfo->uid> 0)
{
    echo form_open('comment/add',array('name'=> 'commentform', 'id' => 'commentform', 'onsubmit' => 'return false')), form_hidden('ajx', 1), form_hidden('imageid', $imageinfo->imageid),form_hidden('uid', $imageinfo->uid);
?>
                <input type="hidden" name="cid" />
                <textarea rows="2" cols="80" name="addcomment" id="addcomment" class="fl" onkeyup="strlen_verify(this, 'comment-max', 140);"></textarea>
                <input type="submit" class="btn w50 fl" id="doaddcomment" value="提交" />
                <label for="addcomment" id="addcomment-label">我也来说两句</label>
                <span id="comment-max">140</span>
                </form>
<?php }else{?>
                <p class="tr">请&nbsp;<a href="member/login" onclick="mtWindow('login', 'member/login_float?redirect=-1');return false;" class="b">登录</a>&nbsp;后发表评论。没有账号？&nbsp;<a href="member/register" class="b">点击注册</a></p>
<?php }?>
            </div>
        </div>
    </article>
    <div class="fl mt10 ml10">
        <div class="action-bar">
            <ul>
                <li><a href="javascript:void(0);" onclick="$('.heart').click();return false;" class="tg-pink">喜欢</a></li>
                <li><a href="#commentform" class="tg-green">评论</a></li>
                <li><a class="tg-pink">分享</a></li>
            </ul>
        </div>
        <a href="javascript:void(0);" id="scrolltop" class="tg-green">返回顶部</a>
    </div>
    <aside class="relaside fr pr">
<?php
if(isset($other_image) && $other_image)
{
?>
            <div class="pt10 pb10"><strong>所属专辑</strong><a href="album/<?php echo $albuminfo->albumid?>" class="b ml10"><?php echo $albuminfo->albumname?>(<?php echo $albuminfo->images?>)</a></div>
            <ul class="acon-bar clearfix">
<?php
    foreach($other_image as $eachimage)
    {
?>
                <li><a href="view/<?php echo $eachimage->imageid?>"><img class="block" alt="<?php echo $eachimage->depict?>" src="<?php echo read_attachment($eachimage->attachment, '_102_85')?>" /></a></li>
<?php
    }
?>
            </ul>
<?php
}
?>
        <div id="aside-fixed">
            <div class="pt10 pb10"><strong>标签</strong></div>
            <ul class="clearfix tag-wrap" id="taglist">
<?php if(isset($taginfo) && $taginfo){foreach($taginfo as $eachtag){?>
                <li><a class="tg-grey" href="tag/<?php echo $eachtag->tagid?>"><?php echo $eachtag->tagname?><?php if($userinfo->uid> 0 && ($userinfo->uid == $eachtag->uid || $userinfo->uid == $imageinfo->uid)){?><span class="deletetag" onclick="deletetag(<?php echo $eachtag->tagid?>, <?php echo $imageinfo->imageid?>, this);return false;">x</span><?php }?></a></li>
<?php }}else{?>
                <li id="notag">还没有标签</li>
<?php }?>
<?php if(isset($userinfo) && $userinfo->uid> 0){?>
                <li id="add-tag-ctrl"><a title="点击添加标签" class="tg-grey" href="javascript:void(0);" onclick="toggletagbox(this)">+</a></li>
<?php }?>
            </ul>
<?php if(isset($userinfo) && $userinfo->uid> 0){?>
            <div id="add-tag-form" class="clearfix pr">
                <?php echo form_open('tag/add',  array('name'=>'addtagform', 'id'=>'addtagform', 'onsubmit' => 'return false')), form_hidden('ajx', '1'), form_hidden('imageid', $imageinfo->imageid);?>
                <input onmouseover="showMenu('mytag', this);return false;" name="tag" id="add-tag" type="text" class="text fl" alt="多个标签使用逗号隔开" value="多个标签使用逗号隔开" /><a href="javascript:void(0);" onclick="addtag(<?php echo $imageinfo->imageid?>);" class="btn">添加标签</a>
                </form>
<?php if(isset($mytag) && $mytag){?>
                <ul id="mytag" class="bc-ff sd clearfix tag-wrap">
                    <li class="wf100 tc pt5 pb5">最近使用的标签（点击直接添加）</li>
<?php foreach($mytag as $myeachtag){?>
                    <li><a class="tg-grey" href="javascript:void(0);" onclick="inserttag(this)"><?php echo $myeachtag->tagname?></a></li>
<?php }?>
                </ul>
<?php }?>
            </div>
<?php }?>
            <div class="pt10 pb10"><strong><?php echo $imageinfo->favetimes?>人喜欢</strong></div>
            <ul class="avtr-sml clearfix">
                <?php if( ! empty($imageinfo->whofave)){foreach($imageinfo->whofave as $faverlist){?><li><a href="member/<?php echo $faverlist->uid?>"><img src="<?php echo avatar_uri($faverlist->uid, 'small')?>" title="<?php echo $faverlist->username?>" alt="<?php echo $faverlist->username?>" /></a></li><?php }}?>
            </ul>
        </div>
    </aside>
</section>
<script type="text/javascript">
<?php if($imageinfo->commenttimes> 0){?>
$(function(){
    cmtpage(null, [<?php echo $imageinfo->imageid?>, <?php echo (int)$this->input->get('p');?>]);
});
<?php }?>
<?php if(isset($userinfo) && $userinfo->uid> 0 && $userinfo->uid == $imageinfo->uid){?>
var crt_depict_form = function(){
    var val = $.trim($(this).text());
    $(this).html('<?php
        echo str_replace("\n", '', form_open('image/edit',  array('name'=>'editdepict','id'=>'editdepict','onsubmit' => 'return false'))),str_replace("\n", '', form_hidden('ajx', '1')),str_replace("\n", '', form_hidden('imageid', $imageinfo->imageid));
        ?><input name="depict" type="text" onblur="changeDepict(\'' + escape(val) + '\', this.value)" class="text" value="" /><span class="opy9 bc-f5 pr10" id="ed-loading"></span></form>');
    $(this).unbind('click');
    $('input[name="depict"]').val('').focus().val(unescape(val));
};
$(function(){
    $('#image-depict').hover(function(){
        $(this).addClass('bc-f5').attr({title:'单击一下可以修改'});
    }, function(){
        $(this).removeClass('bc-f5').removeAttr('title');
    });
    $('#image-depict').click(crt_depict_form);
});
<?php }?>
</script>
<script type="text/javascript" src="static/js/tag.js"></script>
<script type="text/javascript" src="static/js/show.js"></script>
<script type="text/javascript" src="static/js/comment.js"></script>