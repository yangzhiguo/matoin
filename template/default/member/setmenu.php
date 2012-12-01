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
 * @version    $Id setmenu.php v1.0.0 2012-01-14 22:46 $
 */

// ------------------------------------------------------------------------

/**
 * 会员中心设置菜单
 *
 * @package     Maotin
 * @subpackage  Template
 * @category    Front-views
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */
if(isset($memberinfo) && $memberinfo && is_object($memberinfo))
{
?>
<div class="bc-ff p10 sd">
    <img class="block" width="200" height="200" src="<?php echo avatar_uri($memberinfo->uid, 'big')?>" alt="<?php echo $memberinfo->username?>" />
    <div class="pt10">
        <h3 class="fn clearfix block"><span class="fl"><?php echo $memberinfo->username?></span></h3>
        <p class="pb20 pt10" style="overflow:hidden;"><?php echo nl2br($memberinfo->signature)?></p>
        <a href="member/<?php echo $memberinfo->uid?>"><strong class="b"><?php echo $member_count->images?></strong>&nbsp;喜欢</a>
        <span class="c-9">|</span>
        <a href="member/<?php echo $memberinfo->uid?>/albums"><strong class="b"><?php echo $member_count->albums?></strong>&nbsp;专辑</a>
    </div>
</div>
<?php
}

/* End of file setmenu.php */
/* Location: ./template/member/setmenu.php */