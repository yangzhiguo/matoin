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
 * @version    $Id toolaccess.php v1.0.0 12-4-8 下午9:18 $
 */

// ------------------------------------------------------------------------

/**
 * 图片接收工具模版
 *
 * @package     Maotin
 * @subpackage  Template
 * @category    Front-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */
?>
<link href="static/css/album.css" rel="stylesheet" />
<section class="content w960 clearfix">
    <article class="content-wrap mt10 pb20">
        <h3 class="mt20 ml20">分享到猫头鹰</h3>
        <div class="ml20"><?php echo album_modelfield($userinfo->uid, 'collectform-albumid')?></div>
        <?php echo form_open('attachment/collect',  array('name'=>'collectform', 'id'=>'collectform',
        'onclick'=>'return false'));?>
        <input type="hidden" id="collectform-albumid" name="albumid" value="" />
        <input type="hidden" name="origin" value="<?php echo rawurlencode($link)?>" />
        <ul class="clearfix ml20" id="collect_piclist">
            <?php foreach($src as $order => $imgurl){?>
            <li>
                <a title="关闭" class="close" href="javascript:void(0);">关闭</a>
                <a class="block" style="height:180px"><img src="<?php echo $imgurl?>" alt="" /></a>
                <input type="hidden" name="imgurl[]" value="<?php echo rawurlencode($imgurl)?>" />
                <textarea title="添加描述"  name="desc[]" class="text"><?php echo $title?></textarea>
            </li>
            <?php }?>
        </ul>
        <input type="submit" class="btn w50 mt10 ml20" name="dosubmit" id="collectdosubmit" onclick="return collect('collectform', 'collectloading', this.id)" value="发布" />
        <span id="collectloading" class="pl10"></span>
        </form>
    </article>
    <aside class="w220 fr"><a href="javascript:void(0);" id="scrolltop" class="tg-green" hidefocus="true">返回顶部</a></aside>
</section>
<script type="text/javascript" src="static/js/collect.js" ></script>
<script type="text/javascript">
$('#collect_piclist .close').click(function(){
    if(parseInt($(this).parent().parent().find('li').length)> 1){
        $(this).parent().remove();
    }else{
        showMsgbox('不能删除最后一个图片', 'error');
        return false;
    }
});
</script>
<?php
/* End of file toolaccess.php */
/* Location: ./template/content/toolaccess.php */