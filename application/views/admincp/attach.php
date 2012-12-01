<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Maotin System
 *
 * 猫头鹰Maotin - 寻找最有价值的东西
 *
 * Maotin - to help you find the most valuable thing
 *
 * @package    Maotin
 * @author     yzg <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2011 - 2012, maotin.com.
 * @license    GNU General Public License 2.0
 * @link       http://www.maotin.com/
 * @version    $Id attach.php v1.0.0 2012-02-19 03:22 $
 */

// ------------------------------------------------------------------------

/**
 * attach.php
 *
 * @package     Maotin
 * @subpackage  admincp
 * @category    admincp-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */
?>
<h3 class="bc-g p6">上传设置</h3>
<?php
echo form_open('admincp/index/attach',  array('name'=>'attachform', 'id'=>'attachform'));
echo form_hidden('ajx', '1');
?>
<p><strong>本地附件保存位置：</strong></p>
<p><input type="text" name="setting[attachdir]" size="40" value="<?php echo isset($attachdir) ? $attachdir : ''?>" /><span class="pl20">服务器路径，属性 777，必须为 web 可访问到的目录，结尾不加 "/"，相对目录务必以 "./" 开头</span></p>
<p><strong>本地附件 URL 地址：</strong></p>
<p><input type="text" name="setting[attachurl]" size="40" value="<?php echo isset($attachurl) ? $attachurl : ''?>" /><span class="pl20">可为当前 URL 下的相对地址或 http:// 开头的绝对地址，结尾不加 "/"，不能把这个设为远程附件URL地址</span></p>
<p><strong>缩略图质量：</strong></p>
<p><input type="text" name="setting[thumbquality]" size="10" value="<?php echo isset($thumbquality) ? $thumbquality : ''?>" /><span class="pl20">设置图片附件缩略图的质量参数，范围为 0～100 的整数，数值越大结果图片效果越好，但尺寸也越大</span></p>
<p><input type="submit" id="dosubmit" name="dosubmit" onclick="mtAjxPost('attachform', 'formloading', 'formloading', this.id);return false;" value="提交" /></p>
<span id="formloading"></span>
<?php
/* End of file attach.php */
/* Location: ./application/地址/attach.php */