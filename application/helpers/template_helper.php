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
 * @version    $Id template_helper.php v1.0.0 12-5-29 下午5:20 $
 */

// ------------------------------------------------------------------------

/**
 * template Helpers
 *
 * @package     matoin
 * @subpackage  Helpers
 * @category    Extends Helpers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */

/**
 * 模版引入
 *
 * @param string $file
 */
if( ! function_exists('display'))
{
    function display($file = '')
    {
        $CI = & get_instance();
        $CI->load->template_theme_on();
        if (is_file(FCPATH . config_item('template_dir') . config_item('template_theme') . $file . '.php'))
        {
            $CI->load->view($file);
        }
        else
        {
            show_error('template ' . $file . ' not exists!');
        }
    }
}

/* End of file template_helper.php */
/* Location: ./application/helpers/template_helper.php */