function addImage(src){
    $('img#avatar_source').remove();
    var Img = document.createElement("img");
    Img.style.verticalAlign = "middle";
    Img.src = src;
    Img.id = 'avatar_source';
    var areaInit = function(){
        var thumbnails = $('#thumbnails');
        $(Img).hide().fadeIn(1000);
        thumbnails.css({background:'none'}).html(Img);
        initJcrop();
        thumbnails.css({padding:(360-Img.height)/2+'px ' + (360-Img.width)/2+'px',
                              width:360-(360-Img.width)+'px', height:360-(360-Img.height)+'px'});
        $('img.preview').attr({src:src});
        $('#avatar-submit').removeAttr('disabled');
    };
    if ($.browser.msie){
        Img.onreadystatechange = function () {
            if(Img.readyState == "complete"){
                areaInit();
            }
        };
    } else {
        Img.onload = function () {
            if(Img.complete == true){
                areaInit();
            }
        }
    }
}
function initJcrop(){
    $('img#avatar_source').Jcrop({
        onRelease:releaseCheck,
        aspectRatio:1,
        onChange: updatePreview,
        onSelect: updatePreview
    },function(){
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];
        jcrop_api = this;
        jcrop_api.animateTo([0,0,200,200]);
    });
}
function releaseCheck(){
    jcrop_api.setOptions({ allowSelect: true });
}
function updatePreview(c){
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    if (parseInt(c.w) > 0){
        $('.preview').each(function(){
            var rx = $(this).attr('width') / c.w,
                ry = $(this).attr('height') / c.h;
            $(this).css({
                width: Math.round(rx * boundx) + 'px',
                height: Math.round(ry * boundy) + 'px',
                marginLeft: '-' + Math.round(rx * c.x) + 'px',
                marginTop: '-' + Math.round(ry * c.y) + 'px'
            });
        });
    }
}