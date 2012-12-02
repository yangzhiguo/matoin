<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
 * @version    $Id MT_loader.php v1.0.0 2012-01-02 22:24 $
 */

// ------------------------------------------------------------------------

/**
 * MT_loader.php
 *
 * MT_loader.php
 *
 * @package     matoin
 * @subpackage  core
 * @category    Override core
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */

class MT_Loader extends CI_Loader
{
    /**
     * 打开皮肤功能
     *
     * @access public
     * @return boolean
     */
    public function template_theme_on()
    {
        $this->_ci_view_paths[FCPATH .  config_item('template_dir') . config_item('template_theme')] = true;
        return TRUE;
    }

    /**
     * 关闭皮肤功能
     *
     * @access public
     * @return void
     */
    public function template_theme_off()
    {
        //just do nothing
    }

}

//END MT_loader Class

/* End of file MT_loader.php */
/* Location: ./application/core/MT_loader.php */