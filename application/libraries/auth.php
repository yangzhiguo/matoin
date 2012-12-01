<?php defined('BASEPATH') or exit('No direct script access allowed');
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
 * @version    $Id auth.php v1.0.0 2012-01-15 11:13 $
 */

// ------------------------------------------------------------------------

/**
 * 控制用户登陆和登出，以及权限控制ACL实现
 *
 * @package     Maotin
 * @subpackage  Libraries
 * @category    Front-libraries
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */
class Auth
{
    /**
     * 用户信息
     *
     * @access public
     * @var object $userinfo
     */
    public $userinfo = null;

    /**
     * 用户id
     *
     * @access public
     * @var integer $uid
     */
    public $uid = 0;

    /**
     * CI句柄
     *
     * @access private
     * @var object $CI
     */
    private $CI;

    /**
     * 保持在线的时间
     *
     * @access private
     * @var integer $expire
     */
    private $expire = 0;

    /**
     * 保持登录需要存储cookie的名称,不带cookie pre
     *
     * @var string $savedata_key
     */
    private $savedata_key;

    private $savexpire_key;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('Member_model');

        $this->savedata_key = config_item('savedata_key');
        $this->savexpire_key = config_item('savexpire_key');

        $this->userinfo = $this->_get_session();

        $this->uid = isset($this->userinfo->uid) ? (int)$this->userinfo->uid : 0;
    }

    /**
     * 处理用户登出
     *
     * @access public
     * @return void
     */
    public function process_logout()
    {
        $this->expire = -1;
        $this->userinfo = NULL;
        $this->CI->session->sess_destroy();
    }

    /**
     * 处理用户登录
     *
     * @access public
     * @param  object $user 用户信息 object('uid'->int,'username'->string)
     * @param  integer $expire 登录保持(秒数),需开启cookie
     * @return boolean
     */
    public function process_login($user, $expire = 0)
    {
        $this->userinfo = $user;
        $this->ignore_session_key(array('salt', 'password'));
        $this->uid = $user->uid;
        if ($expire> 0)
        {
            $this->CI->session->sess_expiration = $expire;
        }
        $this->_set_session();
        return TRUE;
    }

    /**
     * 删除不用存入cookie的字段
     *
     * @param array $keyvars
     * @return bool
     */
    public function ignore_session_key($keyvars)
    {
        foreach($keyvars as $key)
        {
            if(isset($this->userinfo->$key))
            {
                unset($this->userinfo->$key);
            }
        }
        return TRUE;
    }

    /**
     * 更新cookie中用户信息
     *
     * @param array $data
     * @return bool
     */
    public function update_userdata($data = array())
    {
        foreach($data as $existskey => $newval)
        {
            if(isset($this->userinfo->$existskey))
            {
                $this->userinfo->$existskey = $newval;
            }
        }
        $this->CI->session->set_userdata($this->savedata_key, serialize($this->userinfo));
        return TRUE;
    }

    /**
     * 设置session
     *
     * @access public
     * @return boolean
     */
    public function _set_session()
    {
        $session_data = array(
            $this->savedata_key  => serialize($this->userinfo),
            $this->savexpire_key => $this->CI->session->sess_expiration
        );
        $this->CI->session->set_userdata($session_data);
        return TRUE;
    }

    /**
     * 取得设置的session
     *
     * @access public
     * @return array
     */
    public function _get_session()
    {
        $this->userinfo = unserialize($this->CI->session->userdata($this->savedata_key));
        $this->uid = isset($this->userinfo->uid) ? (int)$this->userinfo->uid : 0;
        return $this->userinfo;
    }
}
//END Auth Class

/* End of file auth.php */
/* Location: ./application/libraries/auth.php */
