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
 * @version    $Id MT_Controller.php v1.0.0 2012-01-02 21:08 $
 */

// ------------------------------------------------------------------------

/**
 * MT_Controller.php
 *
 * 前台通用父控制器
 *
 * @package     matoin
 * @subpackage  core
 * @category    Override core
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class MT_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth');
        $this->load->template_theme_on();
    }

    public function template($view, $vars = array(), $cached = FALSE, $return = FALSE)
    {
        $views = strpos($view, ',') !== FALSE ? explode(',', $view) : array($view);
        unset($view);
        if( ! isset($vars['userinfo']))
        {
            $vars['userinfo'] = $this->auth->uid> 0 ?
                                $this->auth->userinfo :
                                (object)array(
                                    'uid'      => 0,
                                    'username' => '',
                                    'email'    => ''
                                );
        }

        foreach ($views as $view)
        {
            if (file_exists(FCPATH . config_item('template_dir') . config_item('template_theme') . $view . '.php'))
            {
                $this->load->view($view, $vars, $return);
            }
            else
            {
                show_404();
            }
        }

        if (config_item('template_cache_enable') && $cached)
        {
            $this->output->cache(config_item('template_cache_expire'));
        }
    }
}
// END MT_Controller Class

// ------------------------------------------------------------------------

/**
 * 管理台通用控制器
 *
 * @package     matoin
 * @subpackage  Override core
 * @category    Admincp-controller
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class MT_admincp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth');
        if ( ! ($this->auth->uid> 0))
        {
            redirect('member/login');
        }
    }
}

//END MT_admincp Class

/* End of file MT_Controller.php */
/* Location: ./application/libraries/MT_Controller.php */