<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
 * @since      Version ${VERSION} 2012-09-09 上午10:04 $
 * @filesource album_modelfield.php
 */

// ------------------------------------------------------------------------
?>
<style type="text/css">
.album-box{
    background:#FFF;
    position:absolute;
    display:none;
    line-height:28px;
    border:1px solid #D0D0D0;
    z-index:897;
    width:235px
}
.album-box ul{
    overflow-x:hidden;
    overflow-y:auto
}
.album-box li{
    width:100%;
    float:left;
    clear:both;
    overflow:hidden
}
.album-box ul a:hover{
    background:#F5F5F5
}
.album-box ul a,.album-box span{
    display:block;
    padding-left:10px;
    width:100%
}
a.cancelalbum{
    display:none;
    float:left;
    margin-left:5px
}
.close-box{
    position: absolute;
    right:14px;
    top:4px;
}
</style>
<div class="clearfix mt5 mb5" style="line-height:28px">
    <a class="fl mr5 arrow showalbum" href="javascript:void(0);" onclick="return showalbum(this)">选择专辑</a>
    <a class="b cancelalbum" href="javascript:void(0);" onclick="return cancelalbum(this, '<?php echo $inputid?>');">取消</a>
</div>
<div class="sd2 album-box" data-spm="<?php echo $inputid?>">
    <a class="close close-box" title="关闭窗口" href="javascript:void(0);" onclick="return closealbum(this)">关闭窗口</a>
    <ul style="height:0">
        <?php if(isset($myalbums) && $myalbums){foreach($myalbums as $peralbum){?>
        <li><a href="javascript:void(0);" title="单击选择专辑" onclick="return selectalbumid(<?php echo $peralbum->albumid;?>, this);return false;"><?php echo $peralbum->albumname;?></a></li>
        <?php }}?>
        <li id="newalbum<?php echo $inputid?>"></li>
    </ul>
    <div class="m10 clearfix">
        <?php echo form_open('album/add',  array('name'=>'albumaddform' . $inputid, 'id'=>'albumaddform' . $inputid));?>
        <?php echo form_hidden('ajx', 1)?>
        <input type="text" name="newalbumname" alt="输入新专辑名" value="输入新专辑名" style="width:145px" class="text mr10 fl" />
        <input type="submit" class="btn w50 fr" name="doalbumadd" id="doalbumadd<?php echo $inputid?>" onclick="return add_album(this, '<?php echo $inputid?>');" value="创建" />
        </form>
    </div>
</div>
<script type="text/javascript" src="static/js/album.js" ></script>
<?php

/* End of file album_modelfield.php */
/* Location: ${FILE_PATH}/album_modelfield.php */