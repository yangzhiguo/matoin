<?php defined('BASEPATH') or exit('No direct script access allowed');
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
 * @version    $Id avatar.php v1.0.0 2012-01-14 22:46 $
 */

// ------------------------------------------------------------------------

/**
 * 修改头像模版
 *
 * @package     matoin
 * @subpackage  Template
 * @category    Front-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
?>
<link href="static/css/avatar.css" rel="stylesheet" />
<link href="static/css/jquery.Jcrop.css" rel="stylesheet" />
<link href="static/css/swfuprogress.css" rel="stylesheet" />
<section class="clearfix content w960">
    <article class="content-wrap mt10 pb20">
        <div class="clearfix pb10">
            <h3 class="mt20 ml20 fl fn">设置</h3>
            <ul class="mt20 mr20 fr clearfix tabs">
                <li><a href="member/setting">基本设置</a></li>
                <li><a class="act" href="member/avatar" >修改头像</a></li>
                <li><a href="member/pwd">更改密码</a></li>
            </ul>
        </div>
        <div class="clearfix ml20 mt10" style="width:370px">
            <div class="addnew"><span id="btupload"></span></div>
            <span id="btnCancel" class="hidden"></span>
            <div id="fsUploadProgress"></div>
        </div>
        <div id="thumbnails" class="mt10 ml20"></div>
        <div id="bigwarp">
            <div id="big">
                <img src="<?php echo avatar_uri($userinfo->uid, 'big')?>" width="200" height="200" class="preview" alt="大尺寸头像" />
            </div>
            <div class="fl wf100 pb10">大头像</div>
            <div id="mid">
                <img src="<?php echo avatar_uri($userinfo->uid, 'middle')?>" width="120" height="120" class="preview" alt="中尺寸头像" />
            </div>
            <div id="sml">
                <img src="<?php echo avatar_uri($userinfo->uid, 'small')?>" width="50" height="50" class="preview" alt="小尺寸头像" />
            </div>
            <div class="fr smlt">小头像</div>
            <div class="fl midt">中头像</div>
        </div>
        <div class="cb pt10 ml20 clearfix">
            <?php echo form_open('member/avatar',  array('name'=>'avatarform', 'id'=>'avatarform'));?>
            <?php if (isset($error_string)) : echo $error_string; endif;?>
            <input type="hidden" name="x1" id="x1" value="0" />
            <input type="hidden" name="y1" id="y1" value="0" />
            <input type="hidden" name="x2" id="x2" value="200" />
            <input type="hidden" name="y2" id="y2" value="200" />
            <input id="avatar-submit" disabled="disabled" type="submit" class="btn w75" value="保存头像" /><span class="ml30">头像保存后，您可能需要刷新一下本页面(按F5键)，才能查看最新的头像效果</span>
            </form>
        </div>
    </article>
    <aside class="w220 mt10 fr"><?php echo member_modelfield();?></aside>
</section>
<script type="text/javascript">
var swfu;
window.onload = function() {
    var settings = {
        flash_url : "static/image/swfupload.swf",
        flash9_url : "static/image/swfupload_fp9.swf",
        upload_url: '<?php echo site_url('attachment/avatar')?>',
        file_size_limit : "<?php echo $max_size?> KB",
        file_types : "<?php echo $allowed_types?>",
        post_params: <?php echo $post_params?>,
        file_types_description : "Image File",
        file_upload_limit : 0,
        file_queue_limit : 1,
        custom_settings : {
            progressTarget : "fsUploadProgress",
            cancelButtonId : "btnCancel",
            thumbnail_width: 360,
            thumbnail_height: 360,
            thumbnail_quality: 100
        },

        button_image_url: "",
        button_width: 75,
        button_height: 28,
        button_placeholder_id: "btupload",
        button_text_left_padding: 12,
        button_text_top_padding: 3,
        button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
        button_cursor: SWFUpload.CURSOR.HAND,
        button_action : SWFUpload.BUTTON_ACTION.SELECT_FILE,

        swfupload_preload_handler : preLoad,
        swfupload_load_failed_handler : loadFailed,
        file_queued_handler : fileQueued,
        file_queue_error_handler : fileQueueError,
        file_dialog_complete_handler : fileDialogComplete,
        upload_start_handler : uploadStart,
        upload_progress_handler : uploadProgress,
        upload_error_handler : uploadError,
        upload_success_handler : uploadSuccess,
        upload_complete_handler : uploadComplete,
        queue_complete_handler : queueComplete
};
    swfu = new SWFUpload(settings);
};
</script>
<script type="text/javascript" src="static/js/swfupload.js"></script>
<script type="text/javascript" src="static/js/swfupload.queue.js"></script>
<script type="text/javascript" src="static/js/fileprogress.js"></script>
<script type="text/javascript" src="static/js/handlers.js"></script>
<script type="text/javascript" src="static/js/avatar.js"></script>
<script type="text/javascript" src="static/js/jquery.Jcrop.min.js"></script>
<?php
/* End of file avatar.php */
/* Location: ./template/member/avatar.php */