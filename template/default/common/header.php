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
 * @version    $Id header.php v1.0.0 2012-01-10 21:30 $
 */

// ------------------------------------------------------------------------

/**
 *
 * 公共头部文件
 *
 * @package     matoin
 * @subpackage  Template
 * @category    Front-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($seo['title']) ? $seo['title'] : '猫头鹰 - 优美图片休憩之地'?></title>
    <meta name="keywords" content="猫头鹰,优美图片,美图,分享,收藏" />
    <meta name="description" content="猫头鹰,优美图片休憩之地。这是一个收藏、分享、发现优美图片、清新图片的社区，是我们美好的栖息之地。" />
    <base href="<?php echo base_url();?>" />
    <link href="static/css/global.css" rel="stylesheet" />
    <link href="static/css/content.css" rel="stylesheet" />
    <!--[if lte IE 8]><script src="static/js/html5.js"></script><![endif]-->
    <script src="static/js/jquery-1.7.1.min.js"></script>
</head>
<body>
<div id="append_parent"></div>
<nav class="top-header clearfix">
    <div class="main-nav w960 clearfix">
        <div id="logo" class="fl"><a href="javascript:void(0);" class="logo-font">猫头鹰</a></div>
        <ul id="nav-list">
            <li><a href="<?php echo site_url()?>">首页</a></li>
            <li><a href="<?php echo site_url('hot')?>">热门</a></li>
            <li><a href="<?php echo site_url()?>">专辑</a></li>
            <li><a href="<?php echo site_url('tag')?>">标签</a></li>
            <li><a href="<?php echo site_url('tool')?>">收藏工具</a></li>
        </ul>
        <div class="fl ml20" style="height:38px;padding-top:8px">
            <input type="text" style="border-radius: 3px 0 0 3px;border: none;background:#FFF;" size="30" class="text fl">
            <input type="submit" class="fl" style="
            background:#FFF url(static/image/srch_btn.png) no-repeat center center;
            border:none;
            height:30px;
            width:30px;
            cursor:pointer;
            border-radius:0 3px 3px 0;
            " onmouseover="this.style.backgroundColor='#F5F5F5'" onmouseout="this.style.backgroundColor='#FFF'" value="" />
        </div>
        <div class="fr login-info pr clearfix"><?php if (! ($userinfo->uid> 0)) : ?><a href="member/login" onclick="mtWindow('login', 'member/login_float?redirect=-1');return false;">登录</a><a class="ml10" href="member/register">注册</a><?php endif;if ($userinfo->uid> 0) : ?><a class="arrow block" onmouseover="showMenu('more-nav', this)" href="member/<?php echo $userinfo->uid?>"><img src="<?php echo avatar_uri($userinfo->uid, 'small')?>" width="20" height="20" style="vertical-align:middle;" />
            <span><?php echo $userinfo->username?></span></a>
            <ul id="more-nav" class="sd clearfix">
                <li><a href="javascript:void(0);" id="more-nav-pic" onclick="mtWindow('publish', 'publish');return false;">发布</a></li>
                <li><a href="member/<?php echo $userinfo->uid?>/albums" id="more-nav-album">我的专辑</a></li>
                <li><a href="member/setting" id="more-nav-setting">设置</a></li>
                <li><a href="member/logout" id="more-nav-logout">退出</a></li>
            </ul><?php endif;?></div>
    </div>
    <!-- nav end -->
</nav>
<?php
/* End of file header.php */
/* Location: ./application/template/common/header.php */