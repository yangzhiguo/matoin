<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Maotin System
 *
 * 猫头鹰Maotin - 帮你寻找最有价值的东西
 *
 * Maotin - to help you find the most valuable thing
 *
 * @package    Maotin
 * @author     yzg <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2011 - 2012, maotin.com.
 * @license    GNU General Public License 2.0
 * @link       http://www.maotin.com/
 * @version    $Id home.php v1.0.0 2012-01-08 03:50 $
 */

// ------------------------------------------------------------------------

/**
 * Maotin Regex Helpers
 *
 *
 * @package     Maotin
 * @subpackage  Helpers
 * @category    Extends Helpers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */

// ------------------------------------------------------------------------

/**
 * Validate pcusername 中文、字母、数字、_
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('valid_pcusername'))
{
    function valid_pcusername($pcusername)
    {
        return ( ! preg_match("/^[\x{4e00}-\x{9fa5}\w]+$/u", $pcusername)) ? FALSE : TRUE;
    }
}

// ------------------------------------------------------------------------

/**
 * Validate length 字符串长度限制
 *
 * @access public
 * @param string $haystack
 * @param int $min
 * @param int $max
 * @return bool
 */
if( ! function_exists('valid_length'))
{
    function valid_length($haystack, $min = 0, $max = 0)
    {
        $haystack_len = mb_strlen($haystack);
        return $min <= $haystack_len && $haystack_len <= $max;
    }
}

/* End of file regex_helper.php */
/* Location: ./application/helpers/regex_helper.php */