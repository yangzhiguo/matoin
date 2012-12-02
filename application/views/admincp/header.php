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
 * @version    $Id header.php v1.0.0 2012-02-19 01:10 $
 */

// ------------------------------------------------------------------------

/**
 * header.php
 *
 * @package     matoin
 * @subpackage  admincp
 * @category    admincp-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <base href="<?php echo base_url();?>" />
    <link href="static/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="static/css/global.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        a{
            text-decoration:none
        }
        a:hover{
            text-decoration:none
        }
        .w-20{
            width:20px
        }
        .w-40{
            width:40px
        }
        .f-l{
            float:left
        }
        .f-r{
            float:right
        }
        .clr{
            clear:both
        }
        .mt20{
            margin-top:20px
        }
        a{
            outline:none
        }
        body{
            background-color:#111
        }
        .header{
            background-color:#232323;
            border-bottom:1px solid #151515;
            display:block;
            min-width:984px;
            position:relative
        }
        .header .container{
            height:64px;
            position:relative
        }
        .container{
            margin:0 auto;
            width:984px
        }
        .container p{
            padding:5px;
            border-bottom:1px solid transparent
        }
        .container a{
            color:#7E7E7E
        }
        .nav{
            background-color:#333333;
            border-bottom:1px solid #444444;
            border-top:1px solid #383838;
            box-shadow:0 2px 0 0 #262626,0 -1px 0 0 #171717;
            display:block;
            margin-bottom:2px;
            min-width:984px;
            position:relative;
            z-index:0;
            height:46px
        }
        .nav ul{
            width:994px;
            margin:0 auto
        }
        .nav li{
            display:inline-block;
            float:left;
            font-size:12px;
            line-height:18px;
            position:relative;
            z-index:5000
        }
        .nav li a{
            color:#C5C5C5;
            display:inline-block;
            font-size:12px;
            line-height:18px;
            margin-top:9px;
            padding:6px 10px;
            position:relative;
            text-shadow:0 1px rgba(29,29,29,0.2);
            top:-1px
        }
        .nav li a:hover{
            background:-moz-linear-gradient(#269ACF,#1581BF) repeat scroll 0 0 #1A8FC9;
            background-color:#269ACF;
            border-bottom:1px solid #001F74;
            color:#FFFFFF;
            text-decoration:none
        }
        ul.dropdown{
            background-color:#FFFFFF;
            border-bottom:1px solid rgba(35,35,35,0.2);
            box-shadow:4px 4px 0 0 rgba(35,35,35,0.1);
            left:20px;
            padding:6px 15px;
            position:absolute;
            top:39px;
            width:150px;
            z-index:9999
        }
        ul.dropdown{
            display:none;
            filter:alpha(opacity=0);
            opacity:0
        }
        ul.dropdown li{
            display:block;
            float:none;
            font-size:inherit;
            line-height:24px;
            margin:0;
            padding:0;
            z-index:auto
        }
        ul.dropdown li a{
            border-bottom:none;
            color:#7E7E7E;
            display:block;
            line-height:24px;
            margin:0;
            padding:0;
            position:static;
            text-shadow:0 0 transparent
        }
        ul.dropdown li a:hover{
            border-bottom:none;
            background:#FFFFFF;
            color:#232323
        }
        .page-info{
            background:#111;
            border-bottom:1px solid #333;
            border-top:1px solid #111
        }
        .page-info .container{
            padding-bottom:5px
        }
        .page-info .breadcrumbs{
            color:#666666;
            font-size:12px;
            padding-top:5px
        }
        .content{
            border-top:1px solid #222;
            margin:0 auto;
            min-height:240px;
            padding:20px 0 30px;
        }
        .copyright{
            height:45px;
            min-width:984px;
            text-align:center
        }
        .copyright p{
            padding:10px 0
        }
        .copyright a{
            text-decoration:none
        }
        .bc-g{
            background:#222;
            color:#5FFD08;
            text-shadow:#5FFD08 0 0 1px;
        }
        #ajxwaitid{
            display:block;
            right:0;
            top:0;
            z-index:1;
            padding:0 5px;
            background:#D00;
            color:#FFF
        }
        #formloading{
            padding:5px 10px;
            color:#D00;
            display:block;
            text-shadow: 0 0 1px #D00;
        }
        input[type=text]{
            border:1px solid #000;
            padding:5px;
            font:12px/1.5 Helvetica,'宋体',sans-serif
        }
        input[type=submit], input[type=button]{
            background:#333;
            border:none;
            color:#FFF;
            padding:5px 10px;
            text-shadow: 0 0 1px #FFF;
        }
        input[type=checkbox], input[type=radio]{
            vertical-align:-2px;
            margin-right:3px
        }
    </style>
    <title>猫头鹰 - 管理面板 - To help you find the most valuable thing</title>
</head>
<body>
<div id="ajxwaitid" class="pa"></div>
<div class="nav">
    <ul>
        <li><a href="javascript:void(0);" onclick="menu('admincp/home', '管理中心首页')">管理中心首页</a>
            <ul class="dropdown">
                <li><a href="javascript:void(0);" onclick="menu('admincp/attach', '上传设置')">上传设置</a></li>
                <li><a href="javascript:void(0);" onclick="menu('admincp/ftp', '远程附件设置')">远程附件设置</a></li>
                <li><a href="#">线下活动</a></li>
            </ul>
        </li>
        <li><a href="#">推荐相册</a>
            <ul class="dropdown">
                <li><a href="#">排行</a></li>
                <li><a href="#">名人</a></li>
                <li><a href="#">热点</a></li>
                <li><a href="#">擦边</a></li>
            </ul>
        </li>
        <li><a href="#">上传照片</a>
            <ul class="dropdown">
                <li><a href="#">单张上传</a></li>
                <li><a href="#">批量上传</a></li>
            </ul>
        </li>
        <li><a href="#">我的淡香</a>
            <ul class="dropdown">
                <li><a href="#">我的照片</a></li>
                <li><a href="#">已关注</a></li>
            </ul>
        </li>
        <li><a href="#">设置</a>
            <ul class="dropdown">
                <li><a href="#">隐私设置</a></li>
                <li><a href="#">个人资料</a></li>
                <li><a href="#">系统设置</a></li>
            </ul>
        </li>
    </ul>
</div>
<div class="page-info">
    <div class="container">
        <div class="breadcrumbs">当前位置 &raquo; <span id="position">首页</span></div>
    </div>
</div>
<div class="content">
    <div class="clearfix container" id="container">
<?php
/* End of file header.php */
/* Location: ./application/views/admincp/header.php */