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
 * @version    $Id ftp.php v1.0.0 2012-02-19 21:03 $
 */

// ------------------------------------------------------------------------

/**
 * ftp上传设置
 *
 * @package     matoin
 * @subpackage  admincp
 * @category    admincp-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
?>
<h3 class="bc-g p6">远程附件设置</h3>
<?php
echo form_open('admincp/index/ftp',  array('name'=>'ftpform', 'id'=>'ftpform'));
echo form_hidden('ajx', '1');
?>
<p><strong>是否开启远程附件：</strong></p>
<p>
    <input type="radio" name="setting[ftpon]" id="ftpon1" value="1" /><label for="ftpon1">开启</label>
    <input type="radio" name="setting[ftpon]" id="ftpon0" value="0" checked="checked" /><label for="ftpon0">关闭</label>
    <span class="pl20">只有开启了远程附件，以下的选项才会生效</span>
</p>
<p><strong>启用 SSL 连接：</strong></p>
<p>
    <input type="radio" name="setting[ssl]" id="ssl1" value="1" /><label for="ssl1">开启</label>
    <input type="radio" name="setting[ssl]" id="ssl0" value="0" /><label for="ssl0">关闭</label>
    <span class="pl20">注意：FTP 服务器必需开启了 SSL</span>
</p>
<p><strong>FTP 服务器地址：</strong></p>
<p>
    <input type="text" name="setting[host]" />
    <span class="pl20">可以是 FTP 服务器的 IP 地址或域名</span>
</p>
<p><strong>FTP 服务器端口:</strong></p>
<p>
    <input type="text" name="setting[port]" />
    <span class="pl20">默认为 21</span>
</p>
<p><strong>FTP 帐号:</strong></p>
<p>
    <input type="text" name="setting[username]" />
    <span class="pl20">该帐号必需具有以下权限：读取文件、写入文件、删除文件、创建目录、子目录继承</span>
</p>
<p><strong>FTP 密码:</strong></p>
<p>
    <input type="text" name="setting[password]" />
    <span class="pl20">基于安全考虑将只显示 FTP 密码的第一位和最后一位，中间显示八个 * 号承</span>
</p>
<p><strong>被动模式(pasv)连接:</strong></p>
<p>
    <input type="radio" name="setting[pasv]" id="pasv1" value="1" /><label for="pasv1">是</label>
    <input type="radio" name="setting[pasv]" id="pasv0" value="0" /><label for="pasv0">否</label>
    <span class="pl20">一般情况下非被动模式即可，如果存在上传失败问题，可尝试打开此设置</span>
</p>
<p><strong>远程附件目录:</strong></p>
<p>
    <input type="text" name="setting[attachdir]" />
    <span class="pl20">远程附件目录的绝对路径或相对于 FTP 主目录的相对路径，结尾不要加斜杠“/”，“.”表示 FTP 主目录</span>
</p>
<p><strong>远程访问 URL:</strong></p>
<p>
    <input type="text" name="setting[attachurl]" />
    <span class="pl20">支持 HTTP 和 FTP 协议，结尾不要加斜杠“/”；如果使用 FTP 协议，FTP 服务器必需支持 PASV 模式，为了安全起见，使用 FTP 连接的帐号不要设置可写权限和列表权限</span>
</p>
<p><strong>FTP 传输超时时间:</strong></p>
<p>
    <input type="text" name="setting[timeout]" />
    <span class="pl20">单位：秒，0 为服务器默认</span>
</p><p><strong>连接测试:</strong></p>
<p>
    <input type="button" value="测试远程附件" />
    <span class="pl20">无需保存设置即可测试，请在测试通过后再保存</span>
</p>
<p>
    <input type="submit" id="dosubmit" name="dosubmit" onclick="mtAjxPost('ftpform', 'formloading', 'formloading', this.id);return false;" value="提交" />
</p>
<span id="formloading"></span>
<?php

/* End of file ftp.php */
/* Location: ./application/views/admincp/ftp.php */