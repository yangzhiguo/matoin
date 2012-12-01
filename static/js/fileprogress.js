function FileProgress(file, targetID) {
	this.fid = file.id;
	this.opacity = 100;
	this.height = 0;
	this.fileProgressWrapper = _(this.fid);
	if (!this.fileProgressWrapper) {
		this.fileProgressWrapper = document.createElement("div");
		this.fileProgressWrapper.className = "progressWrapper";
		this.fileProgressWrapper.id = this.fid;

        this.fileProgressElement = document.createElement("div");
		this.fileProgressElement.className = "progressContainer";

		var progressCancel = document.createElement("a");
		progressCancel.className = "progressCancel";
		progressCancel.href = "#";
		progressCancel.style.visibility = "hidden";
		progressCancel.appendChild(document.createTextNode(" "));

		var progressBar = document.createElement("div");
		progressBar.className = "progressBarInProgress";

		var progressStatus = document.createElement("div");
		progressStatus.className = "progressBarStatus";
		progressStatus.innerHTML = "&nbsp;";

		this.fileProgressElement.appendChild(progressCancel);
		this.fileProgressElement.appendChild(progressStatus);
		this.fileProgressElement.appendChild(progressBar);

		this.fileProgressWrapper.appendChild(this.fileProgressElement);

		_(targetID).appendChild(this.fileProgressWrapper);
	} else {
		this.fileProgressElement = this.fileProgressWrapper.firstChild;
		this.reset();
	}

	this.height = this.fileProgressWrapper.offsetHeight;
	this.setTimer(null);
}

FileProgress.prototype.setTimer = function (timer) {
	this.fileProgressElement["FP_TIMER"] = timer;
};
FileProgress.prototype.getTimer = function (timer) {
	return this.fileProgressElement["FP_TIMER"] || null;
};

FileProgress.prototype.reset = function () {
	this.fileProgressElement.className = "progressContainer";

	this.fileProgressElement.childNodes[1].innerHTML = "&nbsp;";
	this.fileProgressElement.childNodes[1].className = "progressBarStatus";
	
	this.fileProgressElement.childNodes[2].className = "progressBarInProgress";
	this.fileProgressElement.childNodes[2].style.width = "0%";
};

FileProgress.prototype.setProgress = function (percentage) {
	this.fileProgressElement.className = "progressContainer";
	this.fileProgressElement.childNodes[2].className = "progressBarInProgress";
	this.fileProgressElement.childNodes[2].style.width = percentage + "%";
	this.fileProgressElement.childNodes[2].innerHTML = percentage + "%";
};
FileProgress.prototype.setComplete = function () {
	this.fileProgressElement.className = "progressContainer";
	this.fileProgressElement.childNodes[2].className = "progressBarComplete";
	this.fileProgressElement.childNodes[2].style.width = "";

	var oSelf = this;
	this.setTimer(setTimeout(function () {
		$('#' + oSelf.fid).fadeOut(300, function(){
            $(this).remove();
        });
	}, 1500));
};
FileProgress.prototype.setError = function () {
	this.fileProgressElement.className = "progressContainer c-d00";
	this.fileProgressElement.childNodes[2].className = "progressBarError";
	this.fileProgressElement.childNodes[2].style.width = "";

	var oSelf = this;
	this.setTimer(setTimeout(function () {
        $('#' + oSelf.fid).fadeOut(300, function(){
            $(this).remove();
        });
	}, 1500));
};
FileProgress.prototype.setCancelled = function () {
	this.fileProgressElement.className = "progressContainer";
	this.fileProgressElement.childNodes[2].className = "progressBarError";
	this.fileProgressElement.childNodes[2].style.width = "";

	var oSelf = this;
	this.setTimer(setTimeout(function () {
        $('#' + oSelf.fid).fadeOut(300, function(){
            $(this).remove();
        });
	}, 1500));
};
FileProgress.prototype.setStatus = function (status) {
	this.fileProgressElement.childNodes[1].innerHTML = status;
};

FileProgress.prototype.toggleCancel = function (show, swfUploadInstance) {
	this.fileProgressElement.childNodes[0].style.visibility = show ? "visible" : "hidden";
	if (swfUploadInstance) {
		var fileID = this.fid;
		this.fileProgressElement.childNodes[0].onclick = function () {
			swfUploadInstance.cancelUpload(fileID);
			return false;
		};
	}
};