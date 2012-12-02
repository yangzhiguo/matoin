<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
 * @version    $Id footer.php v1.0.0 2012-02-19 01:10 $
 */

// ------------------------------------------------------------------------

/**
 * footer.php
 *
 * @package     matoin
 * @subpackage  admincp
 * @category    admincp-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
?>
</div>
</div>
<div class="copyright">
    <p>&copy;matoin&nbsp;<?php echo date('Y', TIME);?></p>
</div>
<div class="pf" id="player" style="bottom:0;right:0">
    <iframe name="iframe_canvas" src="http://douban.fm/partner/baidu/doubanradio?canvas_pos=search&amp;keyword=%E8%B1%86%E7%93%A3%E7%94%B5%E5%8F%B0&amp;app_qid=d635d3a703f77072&amp;app_sid=1179&amp;app_cid=0&amp;bd_user=0&amp;bd_sig=3b9b58c3bd56f6cecc6adc0553dfa771" scrolling="no" allowtransparency="true" style="background-color: transparent; height: 186px; " frameborder="0" width="420" height="186"></iframe>
</div>
<a class="pf p6 pl20" href="javascript:void(0);" id="playerswitch" style="bottom:191px;right:0;background:#518C15;color:#FFF;border-radius:10px 0 0 1px">隐藏电台</a>
<script type="text/javascript" src="static/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="static/js/common.js"></script>
<script type="text/javascript">
$(function()
{$('.nav li').hover(function()
{if(!$(this).find("ul").is(':animated'))
{$(this).find("ul").css({display:'block'}).animate({left:0,opacity:1},150);}},function()
{$(this).find("ul").css({display:'none'}).animate({left:20+'px',opacity:0},150);});
    $('.container p').live('mouseover', function(){
        $(this).addClass('bc-g');
    });
    $('.container p').live('mouseout', function(){
        $(this).removeClass('bc-g');
    });
    var sa;
    if(sa = getcookie('matoinadmincp_current'))
    {
        sa = sa.split('@#_');
        menu(sa[0], sa[1]);
    }
    $('#playerswitch').toggle(
        function(){
            $('#player').css({'visibility':'hidden'});
            $(this).html('显示电台');
        }
        ,
        function(){
            $('#player').css({'visibility':'visible'});
            $(this).html('隐藏电台');
        }
    );
});
function menu(url, title)
{
    $('#position').html(title);
    var efunc = function (){
            $('#ajxwaitid').html('').hide();
    };
    $('#ajxwaitid').html(WAIT).show();
    mtAjx({type:'get', url:url, cache:false}, 'container', efunc, -1);
    setcookie('matoinadmincp_current', url + '@#_' + title, 86400);
}
var cookiepre = 'mt_cookie', cookiedomain = '', cookiepath = '';
function setcookie(cookieName, cookieValue, seconds, path, domain, secure) {
    var expires = new Date();
    if(cookieValue == '' || seconds < 0) {
        cookieValue = '';
        seconds = -2592000;
    }
    expires.setTime(expires.getTime() + seconds * 1000);
    domain = !domain ? cookiedomain : domain;
    path = !path ? cookiepath : path;
    document.cookie = escape(cookiepre + cookieName) + '=' + escape(cookieValue)
        + (expires ? '; expires=' + expires.toGMTString() : '')
        + (path ? '; path=' + path : '/')
        + (domain ? '; domain=' + domain : '')
        + (secure ? '; secure' : '');
}

function getcookie(name, nounescape) {
    name = cookiepre + name;
    var cookie_start = document.cookie.indexOf(name);
    var cookie_end = document.cookie.indexOf(";", cookie_start);
    if(cookie_start == -1) {
        return '';
    } else {
        var v = document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length));
        return !nounescape ? unescape(v) : v;
    }
}
</script>
</body>
</html>
<?php
/* End of file footer.php */
/* Location: ./application/views/admincp/footer.php */