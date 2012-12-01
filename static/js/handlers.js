function preLoad() {
	if (!this.support.loading) {
		alert("请升级您的Flash Player到9.028或以上版本");
		return false;
	}
}
function loadFailed() {
	alert("上传组件加载失败，请与猫头鹰管理员联系");
}

function fileQueued(file) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("等待上传...");
		progress.toggleCancel(true, this);
	} catch (ex) {
		this.debug(ex);
	}

}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("选择的文件数量过多");
			return;
		}

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			progress.setStatus("上传的文件太大");
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			progress.setStatus("请不要上传空文件");
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			progress.setStatus("该文件类型不允许上传");
			break;
		default:
			if (file !== null) {
				progress.setStatus("未知错误，无法上传");
			}
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}
var filenum = 0;
function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (numFilesSelected > 0) {
			_(this.customSettings.cancelButtonId).disabled = false;
		}
		this.startResizedUpload(this.getFile(filenum).id, this.customSettings.thumbnail_width, this.customSettings.thumbnail_height, SWFUpload.RESIZE_ENCODING.JPEG, this.customSettings.thumbnail_quality, false);
        filenum ++;
	} catch (ex)  {
        this.debug(ex);
	}
}

function uploadStart(file) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("上传中请稍后...");
		progress.toggleCancel(true, this);
	}
	catch (ex) {}
	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		progress.setStatus("上传中请稍后...");
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
        if (serverData.substring(0, 7) === "FILEID:") {
            progress.setComplete();
            progress.setStatus("上传成功");
            progress.toggleCancel(false);
            addImage(serverData.substring(7));
        }else{
            progress.setError();
            progress.setStatus("上传失败，" + serverData.substring(6));
            progress.toggleCancel(false);
        }
	}catch(ex){}
}

function uploadError(file, errorCode, message) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			progress.setStatus("上传错误: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			progress.setStatus("上传错误");
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			progress.setStatus("服务器 I/O 错误");
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			progress.setStatus("服务器安全认证错误");
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			progress.setStatus('单次上传文件数限制为 '+SWFUpload.settings.file_upload_limit+' 个');
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			progress.setStatus("附件安全检测失败，上传终止");
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			// If there aren't any files left (they were all cancelled) disable the cancel button
			if (this.getStats().files_queued === 0) {
				_(this.customSettings.cancelButtonId).disabled = true;
			}
			progress.setStatus("上传取消");
			progress.setCancelled();
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			progress.setStatus("上传中止");
			break;
		default:
			progress.setStatus("未知错误: " + errorCode);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
	if (this.getStats().files_queued === 0) {
		_(this.customSettings.cancelButtonId).disabled = true;
	}
}

// 自定义调用函数
function queueComplete(numFilesUploaded) {
	var status = _("divStatus");
	//status.innerHTML = "上传了" + numFilesUploaded + '个文件';
}
