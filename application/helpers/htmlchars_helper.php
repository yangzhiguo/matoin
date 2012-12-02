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
 * @version    $Id htmlchars_helper.php v1.0.0 12-3-20 下午10:44 $
 */

// ------------------------------------------------------------------------

/**
 * html,xml,javascript,php标签处理 htmlchars Helpers
 *
 * @package     matoin
 * @subpackage  Helpers
 * @category    Extends Helpers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */

if( ! function_exists('dhtmlspecialchars'))
{
    /**
     * 返回经htmlspecialchars处理过的字符串或数组
     *
     * @access public
     * @param $val
     * @return array|string
     */
    function dhtmlspecialchars($val)
    {
        if( ! is_array($val))
        {
            return htmlspecialchars($val);
        }
        foreach($val as $skey => $sval)
        {
            $val[$skey] = dhtmlspecialchars($sval);
        }
        return $val;
    }
}

/* End of file htmlchars_helper.php */
/* Location: ./application/helpers/htmlchars_helper.php */