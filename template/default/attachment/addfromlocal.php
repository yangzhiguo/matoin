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
 * @since      Version ${VERSION} 2012-08-29 上午10:26 $
 * @filesource addfromlocal.php
 */

// ------------------------------------------------------------------------
?>
<style type="text/css">
.cros-nav{background: #FFEBEB;color:#FF7A9C}
object{visibility:visible}
#imagepreview{width:200px;height:200px}
#imagepreview img{max-width:200px;max-height:200px;display:block;margin:0 auto}
</style>
<div class="w580">
    <h3 ondblclick="mtHide('mt_frmlocal')" onmousedown="mtDrag(_('mt_frmlocal'), event, 1)" class="fn p10 cur-m">
        <a onclick="mtHide('mt_frmlocal')" title="关闭" id="mt_frmlocal_close" href="javascript:void(0);" class="fr close block">关闭</a>
        <span>本地上传</span>
    </h3>
    <div class="p10 cros-nav">
        <p>将<a href="tool" class="b">收藏按钮</a>加在你的网页浏览器上，就可以随时将网页上的收集贴上来。简单又方便~</p>
    </div>
    <div class="p10 clearfix bc-f5">
        <div id="imagepreview" class="fl bc-eb"></div>
        <div class="fr pr">
            <div class="clearfix">
                <div class="addnew"><span id="localbtupload"></span></div>
                <span id="localbtnCancel" class="hidden"></span>
                <div id="localfsUploadProgress" style="width:262px" class="fl"></div>
            </div>
            <?php echo album_modelfield($userinfo->uid, 'collect_albumform-albumid')?>
            <?php echo form_open('attachment/collect_album',  array('name'=>'collect_albumform', 'id'=>'collect_albumform'));?>
            <input type="hidden" name="albumid" value="" id="collect_albumform-albumid" />
            <input type="hidden" name="imageid" value="" />
            <div>
                <textarea  title="添加描述" alt="这里是美图一张" name="desc" class="text" style="width:335px;height:60px" >这里是美图一张</textarea>
            </div>
            <input type="submit" class="btn w50 mt10" name="dosubmit" id="collect_albumformdosubmit" onclick="collect('collect_albumform', 'collect_albumformloading', this.id);return false;" value="发布" />
            <span id="collect_albumformloading" class="pl10"></span>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="static/js/collect.js"></script>
<script type="text/javascript" src="static/js/swfupload.js"></script>
<script type="text/javascript" src="static/js/swfupload.queue.js"></script>
<script type="text/javascript" src="static/js/fileprogress.js"></script>
<script type="text/javascript" src="static/js/handlers.js"></script>
<script type="text/javascript">
mt_createStyleSheet(['static/css/swfuprogress.css']);
function addImage(src){
    var d = parsejson(src);
    if(d[0] && d[1]){
        $('#imagepreview').html('<img src="' + d[0] + '" alt="" />');
        $('input[name="imageid"]').val(parseInt(d[1]));
    }
}
var filenum_local = 0;
function fileDialogComplete_local(numFilesSelected, numFilesQueued) {
    try {
        if (numFilesSelected> 0) {
            _(this.customSettings.cancelButtonId).disabled = false;
        }
        this.startUpload(this.getFile(filenum_local).id);
        filenum_local ++;
    } catch (ex)  {
        this.debug(ex);
    }
}
var swfu_local;
var settings_local = {
    flash_url : "static/image/swfupload.swf",
    flash9_url : "static/image/swfupload_fp9.swf",
    upload_url: '<?php echo site_url('attachment/uploadfromlocal')?>',
    post_params: <?php echo $post_params?>,
    file_size_limit : "<?php echo $max_size?> KB",
    file_types : "<?php echo $allowed_types?>",
    file_types_description : "Image File",
    file_upload_limit : 0,
    file_queue_limit : 1,
    custom_settings : {
        progressTarget : "localfsUploadProgress",
        cancelButtonId : "localbtnCancel"
    },

    button_image_url: "",
    button_width: 75,
    button_height: 28,
    button_placeholder_id: "localbtupload",
    button_text_left_padding: 12,
    button_text_top_padding: 3,
    button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
    button_cursor: SWFUpload.CURSOR.HAND,
    button_action : SWFUpload.BUTTON_ACTION.SELECT_FILE,

    swfupload_preload_handler : preLoad,
    swfupload_load_failed_handler : loadFailed,
    file_queued_handler : fileQueued,
    file_queue_error_handler : fileQueueError,
    file_dialog_complete_handler : fileDialogComplete_local,
    upload_start_handler : uploadStart,
    upload_progress_handler : uploadProgress,
    upload_error_handler : uploadError,
    upload_success_handler : uploadSuccess,
    upload_complete_handler : uploadComplete,
    queue_complete_handler : queueComplete
};
swfu_local = new SWFUpload(settings_local);
</script>
<?php
/* End of file addfromlocal.php */
/* Location: ${FILE_PATH}/addfromlocal.php */