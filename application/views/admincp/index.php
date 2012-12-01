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
 * @version    $Id index.php v1.0.0 2012-02-19 01:05 $
 */

// ------------------------------------------------------------------------

/**
 * 管理台首页
 *
 * @package     Maotin
 * @subpackage  admincp
 * @category    admincp-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */
?>
<h3 class="bc-g p6">管理中心首页</h3>
<p><span class="block wf-32 fl">Codeigniter 版本：</span><strong><?php echo CI_VERSION;?></strong></p>
<?php
foreach($system_info as $type => $info)
{
?>
<p><span class="block wf-32 fl"><?php echo $type?>&nbsp;：</span><strong><?php echo $info?></strong></p>
<?php
}
?>

<?php

/* End of file index.php */
/* Location: ./application/views/admincp/index.php */