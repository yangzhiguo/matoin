<style type="text/css">
.pmethod{width:300px;margin:0 auto}
.pmethod li,.pmethod a{float:left}
.pmethod a{width:100px;height:80px;line-height:80px;text-align:center;font-size:14px}
.pmethod a:hover{background: #F5F5F5}
.cros-nav{background: #FFEBEB;color:#FF7A9C}
</style>
<div class="w580">
    <h3 ondblclick="mtHide('mt_publish')" onmousedown="mtDrag(_('mt_publish'), event, 1)" class="fn p10 cur-m">
        <a onclick="mtHide('mt_publish')" title="关闭" id="mt_publish_close" href="javascript:void(0);" class="fr close block">关闭</a>
        <span>发布</span>
    </h3>
    <div class="p10 cros-nav">
        <p>将<a href="tool" class="b">收藏按钮</a>加在你的网页浏览器上，就可以随时将网页上的收集贴上来。简单又方便~</p>
    </div>
    <div>
        <ul class="pmethod clearfix">
            <li><a href="javascript:void(0);" onclick="mtHide('mt_publish');mtWindow('addfromnet', 'publish/addfromnet');return false;">网络上传</a></li>
            <li><a href="javascript:void(0);" onclick="return _init_frmlocal();">本地上传</a></li>
            <li><a href="album/add">创建专辑</a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
function _init_frmlocal(){
    mtHide('mt_publish');
    if(typeof swfu != 'undefined'){
        showDialog('猫头哥又出来坑爹了！！修改头像时无法上传本地图片！囧...<br />点“确定”跳转上传，点“取消”暂不上传。', 'confirm', null, function(){redirect('member/setting');});
    }else{
        mtWindow('frmlocal', 'publish/addfromlocal');
    }
    return false;
}
</script>