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
 * @version    $Id has_login_float.php v1.0.0 2012-01-15 23:59 $
 */

// ------------------------------------------------------------------------

/**
 * 已经登录的浮动提示模版
 *
 * @package     matoin
 * @subpackage  Template
 * @category    Front-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
?>
<h3 ondblclick="mtHide('mt_login')" onmousedown="mtDrag(_('mt_login'), event, 1)" class="fn p10 cur-m">
    <a onclick="mtHide('mt_login')" title="关闭" id="mt_login_close" href="javascript:void(0);" class="fr close block">关闭</a>
    <span>提示信息</span>
</h3>
<div class="p10 pt5 w350 dialog-confirm"><p>登录成功！</p></div>
<div class="p10 bc-eb tr">
    <input type="button" onclick="redirect('<?php echo $referrer;?>')" value="立即跳转" id="mt_login_submit" class="btn w75">
</div>
<?php
/* End of file has_login_float.php */
/* Location: ./template/dafault/member/has_login_float.php */