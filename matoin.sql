-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 10 月 30 日 18:40
-- 服务器版本: 5.5.24
-- PHP 版本: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `matoin`
--

-- --------------------------------------------------------

--
-- 表的结构 `mt_album`
--

CREATE TABLE IF NOT EXISTS `mt_album` (
  `albumid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `albumname` varchar(96) NOT NULL DEFAULT '' COMMENT '专辑名',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '创建者id',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `images` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '图片数量',
  `coverpic` varchar(200) NOT NULL DEFAULT '' COMMENT '封面图片',
  `depict` varchar(1200) NOT NULL COMMENT '描述',
  `favtimes` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '喜欢此专辑的次数',
  PRIMARY KEY (`albumid`),
  KEY `uid` (`uid`,`updatetime`),
  KEY `updatetime` (`updatetime`),
  KEY `albumname` (`albumname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专辑' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mt_comment`
--

CREATE TABLE IF NOT EXISTS `mt_comment` (
  `cid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `itemid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `idtype` varchar(20) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `author` char(16) NOT NULL DEFAULT '',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `authorid` (`authorid`,`idtype`),
  KEY `itemid` (`itemid`,`idtype`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mt_common_setting`
--

CREATE TABLE IF NOT EXISTS `mt_common_setting` (
  `skey` varchar(255) NOT NULL DEFAULT '',
  `svalue` varchar(1600) NOT NULL DEFAULT '',
  PRIMARY KEY (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mt_image`
--

CREATE TABLE IF NOT EXISTS `mt_image` (
  `imageid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片id',
  `albumid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '专辑id',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `postip` char(15) NOT NULL DEFAULT '' COMMENT 'ip地址',
  `depict` varchar(480) NOT NULL DEFAULT '' COMMENT '描述',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `attachment` varchar(200) NOT NULL DEFAULT '' COMMENT '文件路径',
  `collection` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '收集方式{1:浏览器工具,2:自己上传,3:从互联网上传}',
  `origin` varchar(200) NOT NULL DEFAULT '' COMMENT '图片来源',
  `isremote` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '{1:是,0:否}在远程服务器上',
  `favetimes` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '喜欢的次数',
  `commenttimes` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `tagnum` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '标签数',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态[0:正常,-1:删除]',
  PRIMARY KEY (`imageid`),
  KEY `uid` (`uid`),
  KEY `albumid` (`albumid`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='存储的图片' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mt_imageitem`
--

CREATE TABLE IF NOT EXISTS `mt_imageitem` (
  `imageid` int(10) unsigned NOT NULL COMMENT '图片id',
  `uid` mediumint(8) unsigned NOT NULL COMMENT '用户id',
  `dateline` int(10) unsigned NOT NULL COMMENT '创建时间',
  KEY `imageid` (`imageid`),
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图片收藏表';

-- --------------------------------------------------------

--
-- 表的结构 `mt_sso_member`
--

CREATE TABLE IF NOT EXISTS `mt_sso_member` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(16) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `email` char(80) NOT NULL DEFAULT '',
  `salt` char(6) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mt_sso_member_count`
--

CREATE TABLE IF NOT EXISTS `mt_sso_member_count` (
  `uid` mediumint(8) unsigned NOT NULL,
  `albums` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '专辑数量',
  `images` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '图片数量',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mt_sso_member_profile`
--

CREATE TABLE IF NOT EXISTS `mt_sso_member_profile` (
  `uid` mediumint(8) unsigned NOT NULL,
  `city` varchar(80) NOT NULL DEFAULT '',
  `siteurl` varchar(120) NOT NULL DEFAULT '',
  `signature` varchar(1200) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mt_sso_member_status`
--

CREATE TABLE IF NOT EXISTS `mt_sso_member_status` (
  `uid` mediumint(8) unsigned NOT NULL,
  `regip` char(15) NOT NULL DEFAULT '',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` char(15) NOT NULL DEFAULT '',
  `lastdate` int(10) unsigned NOT NULL DEFAULT '0',
  `lastsendmail` int(10) unsigned NOT NULL DEFAULT '0',
  `emailstatus` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email状态',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mt_tag`
--

CREATE TABLE IF NOT EXISTS `mt_tag` (
  `tagid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签id',
  `tagname` varchar(96) NOT NULL DEFAULT '' COMMENT '标签名',
  `uid` mediumint(8) unsigned NOT NULL COMMENT '创建者id',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `images` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '标签使用次数',
  PRIMARY KEY (`tagid`),
  UNIQUE KEY `tagname` (`tagname`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='标签' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mt_tagitem`
--

CREATE TABLE IF NOT EXISTS `mt_tagitem` (
  `tagid` mediumint(8) unsigned NOT NULL COMMENT '标签id',
  `tagname` varchar(96) NOT NULL DEFAULT '' COMMENT '标签名',
  `uid` mediumint(8) unsigned NOT NULL COMMENT '创建者id',
  `itemid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '关联项id',
  `idtype` varchar(20) NOT NULL DEFAULT '' COMMENT '关联项类型',
  KEY `tagname` (`tagname`),
  KEY `uid` (`uid`),
  KEY `tagid` (`tagid`),
  KEY `idtype` (`idtype`),
  KEY `itemid` (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='标签映射关系';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
