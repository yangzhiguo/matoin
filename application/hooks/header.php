<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * matoin System
 *
 * 猫头鹰matoin - 帮你寻找最有价值的东西
 *
 * matoin - to help you find the most valuable thing
 *
 * @package    matoin
 * @author     yzg <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2011 - 2012, matoin.com.
 * @license    GNU General Public License 2.0
 * @link       http://www.matoin.com/
 * @version    $Id header.php v1.0.0 2012-01-04 22:59 $
 */

// ------------------------------------------------------------------------

/**
 *
 * 程序初始挂钩
 *
 * @package     matoin
 * @subpackage  hooks
 * @category    system hooks
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class Header
{
    /**
     * @var #Fget_instance|?
     */
    private $CI;

    /**
     * 
     */
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * @return bool
     */
    public function charset()
    {
        $this->CI->output->set_header('Content-type:text/html; charset=' . config_item('charset'));
        return TRUE;
    }
}

/* End of file header.php */
/* Location: ./application/hooks/header.php */