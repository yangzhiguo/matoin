<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
 * @version    $Id member_model.php v1.0.0 2012-01-04 22:59 $
 */

// ------------------------------------------------------------------------

/**
 *
 * 会员模型
 *
 * @package     matoin
 * @subpackage  models
 * @category    member models
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class Member_model extends CI_Model
{
    /**
     * @access public
     * @var string 会员基本表
     */
    const T_MEMBER = 'sso_member';

    /**
     * @access public
     * @var string 会员状态表
     */
    const T_MEMBER_STATUS = 'sso_member_status';

    /**
     * @access public
     * @var string 会员简介表
     */
    const T_MEMBER_PROFILE = 'sso_member_profile';

    /**
     * @access public
     * @var string 会员统计表
     */
    const T_MEMBER_COUNT = 'sso_member_count';

    /**
     * @access public
     * @var integer 用户id
     */
    public $uid;

    /**
     * @access public
     * @var string 用户名
     */
    public $username;

    /**
     * @access public
     * @var string 邮箱
     */
    public $email_address;

    /**
     * @access public
     * @var array 非法用户名列表
     */
    public $denyusername = array('matoin');

    /**
     * @access public
     * @var array 非法邮箱名列表
     */
    public $denyemail = array('*@matoin.com');

    public function __construct()
    {
        $this->load->helper('encrypt');
        parent::__construct();
    }

    /**
     * 删除用户
     * @param array $data
     * array(
     *     $uid => 用户id,
     *     $username => 用户名,
     *     $email    => email}
     * )
     * @return integer {
     *              -1:删除失败,
     *              >0:删除成功}
     */
    public function delete($data = array())
    {
        $this->uid      = isset($data['uid']) ? $data['uid'] : $this->uid;
        $this->email_address    = isset($data['email']) ? $data['email'] : $this->email_address;
        $this->username = isset($data['username']) ? $data['username'] : $this->username;

        if($this->uid> 0)
        {
            $this->db->delete(self::T_MEMBER, array('uid' => $this->uid));
            return 1;
        }
        else if( ! empty($this->username))
        {
            $this->db->delete(self::T_MEMBER, array('username' => $this->username));
            return 2;
        }
        elseif( ! empty($this->email_address))
        {
            $this->db->delete(self::T_MEMBER, array('email' => encrypt($this->email_address)));
            return 3;
        }
        else
        {
            return -1;
        }
    }

    /**
     * 编辑用户，可以不传入旧密码和新密码
     * 如果传入新密码，则修改密码为新密码
     *
     * @param $data array
     * array('uid'      => 102,
     *       'username' => 'username',
     *       'password' => 'username',
     *       'newpassword' => 'newpassword',
     *       'email'    => 'x@xx.com');
     * @return integer {-1:用户不存在,
     *                  -2:旧密码错误,
     *                  -3:email已经存在,
     *                  1 :修改成功,
     *                  0 :未作修改}
     */
    public function edit($data = array())
    {
        $password = $newpassword = NULL;
        $updatecache = array();

        $userinfo = $this->getuserinfo($data);
        if(-1 === $userinfo)
        {
            return -1;
        }

        if (isset($data['password']) && ! empty($data['password']))
        {
            $password = $this->_create_password($data['password'], $userinfo->salt);
        }

        $salt = isset($data['salt']) && $data['salt'] ? $data['salt'] : random_string('alnum', 6);
        if (isset($data['newpassword']) && ! empty($data['newpassword']))
        {
            $newpassword = $this->_create_password($data['newpassword'], $salt);
        }

        if ( ! empty($password) && $userinfo->password !== $password)
        {
            return -2;
        }

        if( ! empty($this->username) && $userinfo->username !== $this->username)
        {
            $updatecache['username'] = $this->username;
        }

        if ( ! empty($this->email_address) && $userinfo->email !== $this->email_address)
        {
            $updatecache['email'] = encrypt($this->email_address);
        }

        if ( ! empty($newpassword) && $userinfo->password !== $newpassword)
        {
            $updatecache['password'] = $newpassword;
            $updatecache['salt']     = $salt;
        }

        if ( ! empty($updatecache))
        {
            if($this->uid> 0)
            {
                $this->db->update(self::T_MEMBER, $updatecache, array('uid' => $this->uid));
            }
            else if( ! empty($this->username))
            {
                $this->db->update(self::T_MEMBER, $updatecache, array('username' => $this->username));
            }
            return $this->db->affected_rows();
        }
        else
        {
            return 0;
        }
    }

    /**
     * 读取会员信息
     *
     * @param int $uid
     * @return null|object
     */
    public function get_member($uid = 0)
    {
        $result = NULL;
        $this->db->select('uid,username')->from(self::T_MEMBER)->where('uid', $uid)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->row();
            $query->free_result();
        }
        return $result;
    }

    /**
     * 获取用户信息
     * @param array $data
     * array('uid'      => 102,
     *       'username' => 'username',
     *       'email'    => 'x@xx.com');
     * @return mixed {-1:用户不存在,
     *                (object)userinfo:用户信息}
     */
    public function getuserinfo($data = array())
    {
        $this->uid      = isset($data['uid']) ? $data['uid'] : $this->uid;
        $this->email_address    = isset($data['email']) ? $data['email'] : $this->email_address;
        $this->username = isset($data['username']) ? $data['username'] : $this->username;

        if ($this->uid> 0)
        {
            $this->db
                ->select(self::T_MEMBER . '.uid,username,password,email,salt,' . self::T_MEMBER_PROFILE . '.signature')
                ->from(self::T_MEMBER . ',' . self::T_MEMBER_PROFILE)
                ->where(self::T_MEMBER . '.uid', $this->uid)
                ->where(
                $this->db->protect_identifiers(self::T_MEMBER, TRUE) . '.`uid`',
                $this->db->protect_identifiers(self::T_MEMBER_PROFILE, TRUE) . '.`uid`',
                FALSE
            )
                ->limit(1);
        }
        else if ( ! empty($this->username))
        {
            $this->db->select('uid,username,password,email,salt')->from(self::T_MEMBER)->where('username', $this->username)->limit(1);
        }
        else if ( ! empty($this->email_address))
        {
            $this->db->select('uid,username,password,email,salt')->from(self::T_MEMBER)->where('email', encrypt($this->email_address))->limit(1);
        }
        else
        {
            return -1;
        }
        $query = $this->db->get();

        if ( ! $query->num_rows())
        {
            return -1;
        }

        $userinfo = $query->row();
        $query->free_result();
        $userinfo->email = encrypt($userinfo->email, 'DECODE');
        if( ! isset($this->uid))
        {
            $userinfo->signature = $this->get_profile($userinfo->uid, 'signature')->signature;
        }
        return $userinfo;
    }

    /**
     * 用户登录
     * @param array $data
     * array('username' => 'username',  //uid | username | email
     *       'password' => 'password')
     * @param integer $serializepassword {1:是,0:否}加密密码
     * @return mixed {
     *                -3:未邮箱验证,
     *                -2:密码错误,
     *                -1:用户不存在,
     *                1:登录成功
     *               }
     */
    public function login($data = array(), $expire = 0, $serializepassword = 1)
    {
        $password = isset($data['password']) ? $data['password'] : '';

        $userinfo = $this->getuserinfo($data);
        if(-1 === $userinfo)
        {
            return -1;
        }

        $compare_password = $serializepassword ? $this->_create_password($password, $userinfo->salt) : $password;
        if ($userinfo->password === $compare_password)
        {
            $this->info(array(
                'uid'      => $userinfo->uid,
                'lastdate' => TIME,
                'lastip'   => $this->input->ip_address()
            ), self::T_MEMBER_STATUS, 'update');
            $this->auth->process_login($userinfo, $expire);
            $status = $this->info(array('uid' => $userinfo->uid), self::T_MEMBER_STATUS, 'select', 'emailstatus');
            if(empty($status->emailstatus))
            {
                return -3;
            }
            return 1;
        }
        else
        {
            return -2;
        }
    }

    /**
     * 用户注册
     * @param array $data
     * array('username' => 'username',
     *       'password' => 'password',
     *       'email'    => 'x@xx.com',
     *       'regip'    => '192.168.0.1',
     *       'random'   => '123456'  //非必须
     *       )
     * @return integer {-1 : 必要项空,
     *                  //-2 : 用户名已存在,
     *                  //-3 : email已存在,
     *                  //-4 : 用户名禁止注册,
     *                  //-5 : email禁止注册,
     *                  -6 : 注册失败,
     *                  array: 成功}
     */
    public function register($data = array())
    {
        $salt   = isset($data['salt']) && $data['salt'] ? $data['salt'] : random_string('alnum', 6);
        $password = isset($data['password']) ? $this->_create_password($data['password'], $salt) : '';
        $regip    = isset($data['regip']) ? $data['regip'] : $this->input->ip_address();
        $this->email_address    = isset($data['email']) ? $data['email'] : $this->email_address;
        $this->username = isset($data['username']) ? $data['username'] : $this->username;

        if(!$password || !$regip)
        {
            return -1;
        }

        $data = array(
            'username' => $this->username,
            'password' => $password,
            'email'    => encrypt($this->email_address),
            'salt'     => $salt
        );
        $this->db->insert(self::T_MEMBER, $data);
        $this->uid = $this->db->insert_id();

        if( ! $this->uid)
        {
            return -6;
        }

        $this->info(
            array(
                'regip'    => $regip,
                'lastip'   => $regip,
                'regdate'  => TIME,
                'lastdate' => TIME,
                'emailstatus' => 0
            ),
            self::T_MEMBER_STATUS,
            'insert'
        );
        $this->info(array(), self::T_MEMBER_PROFILE, 'insert');
        $this->info(array(), self::T_MEMBER_COUNT, 'insert');
        $this->check_email_send($this->uid, $this->email_address, $this->username);

        $data['uid']         = $this->uid;
        $data['email']       = $this->email_address;  //未加密邮箱
        $data['signature']   = '';  //签名
        $this->auth->process_login((object)$data);
        return $this->uid;
    }

    /**
     * 发送密码重置邮件
     *
     * @param string $email
     * @return int
     */
    public function lostpwd_email_send($email = '')
    {
        $info = $this->getuserinfo(array('email' => $email));
        if($info === -1)
        {
            return -1;
        }
        $mixstring = rawurlencode(encrypt($info->salt . "\t" . $info->uid . "\t" . $info->email, 'ENCODE', TRUE));
        $link      = site_url('member/resetpwd/' . $mixstring);
        $this->load->helper('mail');
        $mail_status = sendmail($email, $info->username, $link, 'lostpwd');
        if($mail_status === TRUE)
        {
            $this->info(array('uid' => $info->uid, 'lastsendmail' => TIME), self::T_MEMBER_STATUS, 'update');
            return 1;
        }
        return 0;
    }

    /**
     * 重置密码
     *
     * @param int $uid
     * @param string $password
     * @return int
     */
    public function reset_password($uid, $password)
    {
        $salt = random_string('alnum', 6);
        $newpassword = $this->_create_password($password, $salt);
        $updatecache['password'] = $newpassword;
        $updatecache['salt']     = $salt;
        $this->db->update(self::T_MEMBER, $updatecache, array('uid' => $uid));
        return $this->db->affected_rows();
    }

    /**
     * 验证重置密码链接
     *
     * @param string $encrypted
     * @return bool
     */
    public function chkresetpwd($encrypted = '')
    {
        $result = FALSE;
        if(empty($encrypted))
        {
            return $result;
        }

        $parse_string = encrypt($encrypted, 'DECODE', TRUE);
        $parse_array  = explode("\t", $parse_string);
        $salt         = ! empty($parse_array[0]) ? $parse_array[0] : '';
        $uid          = ! empty($parse_array[1]) ? $parse_array[1] : 0;
        $email        = ! empty($parse_array[2]) ? $parse_array[2] : '';
        if(empty($uid) || empty($email) || empty($salt))
        {
            return $result;
        }
        $this->db->select('uid')->from(self::T_MEMBER)->where(array('uid' => $uid, 'email' => encrypt($email), 'salt' => $salt))->limit(1);
        $query = $this->db->get();
        if ( ! $query->num_rows())
        {
            return $result;
        }
        $result = $uid;
        return $result;
    }

    /**
     * 发送验证email
     *
     * @param string $uid
     * @param string $email  未加密的email
     * @param string $username
     * @return bool
     */
    public function check_email_send($uid = '', $email = '', $username = '')
    {
        $status = 0;
        if( ! isset($uid, $email, $username))
        {
            return $status;
        }
        $lastsendmail = $this->info(array('uid' => $uid), self::T_MEMBER_STATUS, 'select', 'lastsendmail,emailstatus');
        if(isset($lastsendmail->emailstatus) && $lastsendmail->emailstatus)
        {
            return -2;
        }
        $mixstring   = rawurlencode(encrypt($uid . "\t" . encrypt($email) . "\t" . $username . "\t" . TIME, 'ENCODE', TRUE));
        $checkuri    = site_url('member/emailcheck/' . $mixstring);
        $this->load->helper('mail');
        $mail_status = sendmail($email, $username, $checkuri, 'chkemail');
        if($mail_status === TRUE)
        {
            $this->info(array('uid' => $uid, 'lastsendmail' => TIME), self::T_MEMBER_STATUS, 'update');
            $status = 1;
        }
        return $status;
    }

    /**
     * 验证email
     *
     * @param string $encrypted_email
     * @return int {0:验证失败,1:成功,2:已验证}
     */
    public function emailcheck($encrypted_email = '')
    {
        $result = 0;
        if(empty($encrypted_email))
        {
            return $result;
        }

        $parse_string = encrypt($encrypted_email, 'DECODE', TRUE);
        $parse_array  = explode("\t", $parse_string);
        $uid          = ! empty($parse_array[0]) ? $parse_array[0] : 0;
        $email        = ! empty($parse_array[1]) ? $parse_array[1] : '';
        $username     = ! empty($parse_array[2]) ? $parse_array[2] : '';
        if(empty($uid) || empty($email) || empty($username))
        {
            return $result;
        }
        $this->db->select('uid')->from(self::T_MEMBER)->where(array('uid' => $uid, 'email' => $email))->limit(1);
        $query = $this->db->get();
        if ( ! $query->num_rows())
        {
            return $result;
        }
        $status = $this->info(array('uid' => $uid), self::T_MEMBER_STATUS, 'select', 'emailstatus');
        if( ! empty($status->emailstatus) && $status->emailstatus == 1)
        {
            $result = 2;
            return $result;
        }
        $this->info(array('uid' => $uid, 'emailstatus' => 1), self::T_MEMBER_STATUS, 'update');
        $userdata = array(
            'uid'       => $uid,
            'username'  => $username,
            'email'     => encrypt($email, 'DECODE'),  //未加密邮箱
            'signature' => '',  //签名
        );
        $this->auth->process_login((object)$userdata);
        $result = 1;
        return $result;
    }

    /**
     * 用户个人详情
     *
     * @param int $uid
     * @param string $fields
     * @return object|null
     */
    public function get_profile($uid, $fields = 'city,siteurl,signature')
    {
        return $this->info(
            array('uid' => $uid),
            self::T_MEMBER_PROFILE,
            'select',
            (string)$fields
        );
    }

    /**
     * 编辑用户详情
     *
     * @param int $uid
     * @param string $city
     * @param string $siteurl
     * @param string $signature
     * @return bool|int|object
     */
    public function edit_profile($uid, $city, $siteurl, $signature = '')
    {
        $this->uid = $uid> 0 ? $uid : $this->uid;
        return $this->info(
            array(
                'uid'       => $this->uid,
                'city'      => $city,
                'siteurl'   => $siteurl,
                'signature' => $signature,
            ),
            self::T_MEMBER_PROFILE,
            'update'
        );
    }

    /**
     * 会员其他关联信息
     *
     * @access private
     * @param $data
     * @param $table
     * @param string $action
     * @param string $fields
     * @return integer|object|bool
     */
    private function info($data, $table, $action = '', $fields = '')
    {
        if (isset($data['uid']) && $data['uid'])
        {
            $this->uid = $data['uid'];
        }
        switch($action)
        {
            case 'update':
                unset($data['uid']);
                $this->db->update($table, $data, array('uid' => $this->uid));
                return $this->db->affected_rows();
                break;
            case 'insert':
                if ( ! isset($data['uid']))
                {
                    $data['uid'] = $this->uid;
                }
                if ( ! $data['uid'])
                {
                    return FALSE;
                }
                $this->db->insert($table, $data);
                return $this->db->insert_id();
                break;
            case 'select':
                if(empty($fields))
                {
                    return FALSE;
                }
                $this->db->select($fields)->from($table)->where('uid', $this->uid)->limit(1);
                $query = $this->db->get();
                if ( ! $query->num_rows())
                {
                    return FALSE;
                }
                $result = $query->row();
                $query->free_result();
                return $result;
                break;
        }
        return FALSE;
    }

    /**
     * 检查用户名
     *
     * @param string $username 用户名
     * @return integer {-4:禁止注册,
     *                  -2:已经存在,
     *                  -1:用户名空,
     *                   1:成功}
     */
    public function checkname($username = '')
    {
        if($username !== '')
        {
            $this->username = $username;
        }
        if( ! $this->username || ! valid_pcusername($this->username) || ! valid_length($this->username, 3, 16))
        {
            return -1;
        }
        //检查非法用户名 ?
        if(!! $this->denyusername && is_array($this->denyusername))
        {
            $denyusername = implode("|", $this->denyusername);
            $pattern = '/^(' . str_replace(array('\\*', ' ', "\|"), array('.*', '', '|'), preg_quote($denyusername, '/')) . ')$/i';
            if(preg_match($pattern, $this->username))
            {
                return -4;
            }
        }
        $this->db->select('username')->from(self::T_MEMBER)->where('username', $this->username)->limit(1);
        $query = $this->db->get();
        return $query->num_rows() ? -2 : 1;
    }

    /**
     * 检查email
     * @param string $email	email
     * @return integer {-5:邮箱长度不合法,
     *                  -4:禁止注册,
     *                  -3:已经存在,
     *                  -1:邮箱格式不正确,
     *                   1:成功}
     */
    public function checkemail($email = '')
    {
        if($email !== '')
        {
            $this->email_address = $email;
        }

        if( ! $this->email_address || ! valid_length($this->email_address, 1, 40))
        {
            return -5;
        }

        if(! valid_email($this->email_address))
        {
            return -1;
        }

        //检查非法邮箱 ?
        if(!! $this->denyemail && is_array($this->denyemail))
        {
            $denyemail = implode("|", $this->denyemail);
            $pattern = '/^(' . str_replace(array('\\*', ' ', "\|"), array('.*', '', '|'), preg_quote($denyemail, '/')) . ')$/i';
            if(preg_match($pattern, $this->email_address))
            {
                return -4;
            }
        }
        $this->db->select('email')->from(self::T_MEMBER)->where('email', encrypt($this->email_address))->limit(1);
        $query = $this->db->get();
        return $query->num_rows() ? -3 : 1;
    }

    /**
     * 检查密码
     *
     * @param array  $data array('uid' => 'uid', 'password' => 'password')
     * @return integer {-1:密码不正确,1:密码正确}
     *
     */
    public function checkpassword($data)
    {
        if ( ! isset($data['password']) || ! $data['password'] || ! isset($data['uid']) || ! $data['uid'])
        {
            return -1;
        }
        $this->uid = $data['uid'];
        $userinfo = $this->getuserinfo(array('uid' => $this->uid));

        $this->db->select('uid')->from(self::T_MEMBER)->where(
            array('uid' => $this->uid, 'password' => $this->_create_password($data['password'], $userinfo->salt))
        )->limit(1);
        $query = $this->db->get();
        return $query->num_rows() ? 1 : -1;
    }

    /**
     * 加密密码
     *
     * @param $password
     * @param $random
     * @return string
     */
    private function _create_password($password, $random)
    {
        return md5(md5($password) . $random);
    }

    /**
     * 设置用户统计数据
     *
     * @param int $uid
     * @param string $field
     * @param int $increment
     * @return mixed|int
     */
    public function set_member_count($uid, $field = '', $increment = 1)
    {
        $this->db
            ->set("`$field`", "`$field` + " . (int)$increment, FALSE)
            ->update(self::T_MEMBER_COUNT, array(), array('uid' => $uid));
        return $this->db->affected_rows();
    }

    /**
     * 读取用户统计数据
     *
     * @param int $uid
     * @param string $fields
     * @return null|object
     */
    public function get_member_count($uid, $fields = '')
    {
        $this->db
            ->select($fields)
            ->from(self::T_MEMBER_COUNT)
            ->where('uid', $uid)
            ->limit(1);
        $query = $this->db->get();
        if ($query->num_rows()> 0)
        {
            $result = $query->row();
            $query->free_result();
            return $result;
        }
        return NULL;
    }
}

//END Member_model.php Class

/* End of file member_model.php */
/* Location: ./application/models/sso/member_model.php */