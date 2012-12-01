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
 * @version    $Id check.php v1.0.0 2012-01-12 23:17 $
 */

// ------------------------------------------------------------------------

/**
 * check.php
 *
 * 检查用户信息合法性
 *
 * @package     Maotin
 * @subpackage  Controllers
 * @category    Front-controllers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */
class Check extends MT_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 检查用户名是否合法
     *
     * @return bool
     */
    public function checkusername()
    {
        $username = $this->input->get('username');
        if (isset($this->auth->userinfo->username) && $username == $this->auth->userinfo->username)
        {
            $this->output->set_output('1');
            return TRUE;
        }
        $response = $this->Member_model->checkname($username);
        $this->output->set_output($response);
        return TRUE;
    }

    /**
     * 检查email是否合法
     *
     * @return bool
     */
    public function checkemail()
    {
        $email = $this->input->get('email');
        $response = $this->Member_model->checkemail($email);
        $this->output->set_output($response);
        return TRUE;
    }

    /**
     * 检查用户是否已经登录
     *
     * @return bool
     */
    public function checklogin()
    {
        $response = $this->auth->uid> 0 ? '1' : '0';
        $this->output->set_output($response);
        return TRUE;
    }
}

//END Check Class

/* End of file check.php */
/* Location: ./application/controllers/member/check.php */