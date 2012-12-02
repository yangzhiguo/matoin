var mt_tool = {
    tool_version : '1.2.0',
    site_url : "http://localhost/matoin/trunk",
    src_url : window.location.href,
    filter_url : /(matoin.com)/i,
    imglist : [],
    selected:[],
    minw:200,
    minh:200,
    cnt:50,
    submitstatus:0,
    _ : function (id){
        return !id ? null : document.getElementById(id);
    },
    c : function(elem, attr, content){
        var e = document.createElement(elem), prop;
        for (prop in attr) {
            if (attr.hasOwnProperty(prop)) {
                e.setAttribute(prop, attr[prop])
            }
        }
        if (content !== undefined) {
            e.innerHTML = content;
        }
        return e;
    },
    toggle : function(){
        var isfilter;
        this.clear();
        if(this.filter() || (isfilter = document.location.href.match(mt_tool.filter_url))){
            this.alert(isfilter ? '在猫头鹰你可以点击红心收藏图片' : "我们在该页上尚未发现可以收藏的图片");
            setTimeout(function(){mt_tool.close_alert();}, 5000);
            return;
        }
        this.show();
    },
    clear : function(){
        if(!this._('mt-stylesheet')){
            document.body.appendChild(this.c('link', {id:'mt-stylesheet', href:this.site_url+'/static/css/tool.css', rel:'stylesheet', type:'text/css', charset:'utf-8'}));
        }
        var clearlist = ['mt-wrap', 'mt-mask'];
        for(var i = 0; i<clearlist.length; i ++){
            if(this._(clearlist[i])){
                document.body.removeChild(this._(clearlist[i]));
            }
        }
    },
    select:function(i){
        if(this.in_array(i, this.selected)){
            for(var j = 0; j <this.selected.length; j ++){
                if(this.selected[j] == i){
                    this.selected[j] = null;
                }
            }
        }else{
            this.selected.push(i);
        }
    },
    sltall : function (){
        var obj = this._('mt-imgs').childNodes;
        var allowslt = Math.min(obj.length, this.cnt);
        for(var i = 0; i <allowslt; i ++){
            this.select_toggle(obj[i]);
        }
    },
    select_toggle : function(obj){
        var imgcount = parseInt(this._('imgcount').innerHTML);
        if(obj.onmouseout === null){
            if(imgcount <this.cnt){
                this._('imgcount').innerHTML = imgcount + 1;
            }
            obj.onmouseout = function (){
                obj.childNodes[1].style.display =
                obj.childNodes[2].style.display = 'none';
                obj.childNodes[2].innerHTML = '选择这张';
            };
            obj.childNodes[1].style.display =
            obj.childNodes[2].style.display = 'none';
            obj.childNodes[2].innerHTML = '选择这张';
        }else{
            if(imgcount <=0){
                return false;
            }else{
                this._('imgcount').innerHTML = imgcount - 1;
            }
            obj.onmouseout = null;
            obj.childNodes[1].style.display =
            obj.childNodes[2].style.display = 'block';
            obj.childNodes[2].innerHTML = '已选择';
        }
        this.select(encodeURI(obj.childNodes[0].src));
    },
    submit:function(){
        var s = 0;
        var fm = this._('sfm');
        if(this.submitstatus){
            fm.submit();
            return;
        }
        for(var i = 0; i <this.selected.length; i ++){
            if(this.selected[i] === null){
                continue;
            }
            s ++;
            fm.appendChild(this.c('input', {type:'hidden', name:'i[]', value:encodeURI(this.selected[i])}));
        }
        if(s> 0){
            var t = this.c('input', {type:'hidden', name:'t', value:encodeURI(document.title)}),
                u = this.c('input', {type:'hidden', name:'u', value:encodeURI(this.src_url)});
            fm.action = this.site_url + '/tool/to';
            fm.appendChild(t);
            fm.appendChild(u);
            this.submitstatus = 1;
            fm.submit();
        }
    },
    show : function(){
        this.mask();
        var mt_bar = this.c('div', {id:'mt-bar'}, '<div id="mt-status"><div>还能选择<span id="imgcount">' + this.cnt + '</span>张</div>' +
                '<a class="mt-a" href="javascript:mt_tool.sltall();">全选/反选</a></div>' +
                '<a href="javascript:mt_tool.clear();" class="mt-x">X</a>' +
                '<form id="sfm" method="get" target="_blank"></form>' +
                '<a href="javascript:mt_tool.submit();" class="mt-btn">收藏选中的图片到猫头鹰</a>'),
            mt_imgs = this.c('div', {id:'mt-imgs'}),
            mt_wrap = this.c('div', {id:'mt-wrap'});
        for(var i = 0; i <this.imglist.length; i ++){
            var slt_a = this.c('a', {'class':'mt-a', href:'javascript:void(0);'});
            slt_a.onclick = function(){
                mt_tool.select_toggle(this);
            };
            slt_a.onmouseover = function (){
                this.childNodes[1].style.display =
                this.childNodes[2].style.display = 'block';
            };
            slt_a.onmouseout = function (){
                this.childNodes[1].style.display =
                this.childNodes[2].style.display = 'none';
            };
            var slt_img = this.c('img', {src:this.imglist[i].src});
            var wh = this.wh(slt_img);
            slt_a.appendChild(slt_img);
            slt_a.appendChild(this.c('span', {'class':'mt-hover'}));
            slt_a.appendChild(this.c('span', {'class':'mt-select'}, '选择这张'));
            slt_a.appendChild(this.c('span', {'class':'mt-dimensions'}, wh[0] + 'x' + wh[1]));
            mt_imgs.appendChild(slt_a);
        }
        mt_wrap.appendChild(mt_bar);
        mt_wrap.appendChild(mt_imgs);
        document.body.appendChild(mt_wrap);
    },
    filter : function(){
        var ignore = true;
        var imgs = document.getElementsByTagName('img');
        for(var i = 0; i <imgs.length; i ++){
            if(imgs[i].width>= this.minw && imgs[i].height>= this.minh){
                ignore = false;
                this.imglist.push(imgs[i]);
            }
        }
        return ignore;
    },
    wh: function(object) {
        var ih, iw, w = object.width, h = object.height, box = 200;
        if (w > box || h > box) {
            if (w > h) {
                ih = box;
                iw = parseInt((w / h) * box);
                object.style.marginLeft = '-' + parseInt((iw - ih) / 2) + 'px';
            } else {
                iw = box;
                ih = parseInt((h / w) * box);
                object.style.marginTop = '-' + parseInt((ih - iw) / 2) + 'px';
            }
        } else {
            iw = w;
            ih = h;
        }
        object.style.width = iw + 'px';
        object.style.height = ih + 'px';
        return [w, h];
    },
    alert : function(c){
        if(this._('mt-dialog')){
            this._('mt-dialog').style.display = 'block';
            this._('mt-c').innerHTML = c;
        }else{
            var dialog = this.c("div", {id: "mt-dialog", "class": "mt-dialog"});
            var x = this.c("a", {href: "javascript:void(0);", "class": "mt-x"}, "X");
            x.onclick = function() {
                mt_tool.close_alert();
            };
            dialog.appendChild(x);
            dialog.appendChild(this.c("div", {"class": "mt-c", id:"mt-c"}, c));
            document.body.appendChild(dialog);
        }
        this.mask(0);
    },
    close_alert : function(){
        if(this._('mt-dialog')){
            this._('mt-dialog').style.display = 'none';
        }
        this.mask(1);
    },
    mask:function(remove){
        if(remove !== undefined && remove == 1){
            if(this._('mt-mask')){
                this._('mt-mask').style.display = 'none';
            }
        }else{
            if(this._('mt-mask')){
                this._('mt-mask').style.display = 'block';
                return;
            }
            document.body.appendChild(this.c('div', {id:'mt-mask', 'class':'mt-mask'}));
        }
    },
    in_array : function(needle, haystack) {
        if(typeof needle == 'string' || typeof needle == 'number') {
            for(var i in haystack) {
                if(haystack[i] == needle) {
                    return true;
                }
            }
        }
        return false;
    }
};
mt_tool.toggle();