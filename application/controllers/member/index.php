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
 * @version    $Id index.php v1.0.0 2012-01-02 10:18 $
 */

// ------------------------------------------------------------------------

/**
 * 会员中心
 *
 * 用于完成会员的各种功能
 *
 * @package     matoin
 * @subpackage  Controllers
 * @category    Front-controllers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class Index extends MT_Controller
{
    /**
     * 之前的网址
     *
     * @access private
     * @var string $referrer
     */
    private $referrer = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->referrer = $this->agent->referrer();
    }

    /**
     * ajax登录
     */
    public function login_float()
    {
        $data =  array(
            'referrer' => $this->referrer,
            'redirect' => $this->input->get('redirect')
        );
        $this->template($this->auth->uid> 0 ? 'member/has_login_float' : 'member/login_float', $data);
    }

    /**
     * 登录
     */
    public function login()
    {
        $ajx = $this->input->post('ajx') == 1 ? TRUE : FALSE;
        if ($this->auth->uid> 0 && ! $ajx)
        {
            redirect();
        }
        $this->form_validation->set_rules('email', '邮箱', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[3]|max_length[16]');
        $data['referrer'] = $this->referrer;
        
        if ($this->form_validation->run() === FALSE)
        {
            if ($ajx)
            {
                $this->output->set_output('邮箱或密码不正确');
            }
            else
            {
                $this->template('common/header,member/login,common/footer', $data);
            }
        }
        else
        {
            $postinfo = array(
                'email'    => $this->input->post('email'),
                'password' => $this->input->post('password'),
            );
            $expire = $this->input->post('remember') == 1 ? config_item('savexpire_key_expiration') : 0;
            $result = $this->Member_model->login($postinfo, $expire);
            switch($result)
            {
                case '-3':
                    if ($ajx)
                    {
                        $this->output->set_output('<script type="text/javascript">redirect(\'member/guide\')</script>');
                    }
                    else
                    {
                        redirect('member/guide');
                    }
                    break;
                case '-2':
                case '-1':
                    $data['error_string'] = '邮箱或密码不正确';
                    if ($ajx)
                    {
                        $this->output->set_output($data['error_string']);
                    }
                    else
                    {
                        $this->template('common/header,member/login,common/footer', $data);
                    }
                    break;
                case '1':
                    $url = $this->input->post('referrer') ? $this->input->post('referrer') : $this->referrer;
                    if ($ajx)
                    {
                        $script = $this->input->post('redirect') == -1 ? 'window.location.reload();' : "redirect(\"$url\");";
                        $this->output->set_output('登录成功，跳转中...<script type="text/javascript">' . $script . '</script>');
                    }
                    else
                    {
                        redirect($url);
                    }
                    break;
            }
        }
    }

    /**
     * 登出
     */
    public function logout()
    {
        $this->auth->process_logout();
        redirect($this->referrer);
    }

    /**
     * 会员注册
     */
    public function register()
    {
        $this->form_validation->set_rules('email', '邮箱', 'trim|required|valid_email|callback__checkemail');
        $this->form_validation->set_rules(
            'username', '用户名', 'trim|required|min_length[3]|max_length[16]|callback__checkusername'
        );
        $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[3]|max_length[16]');

        if ($this->form_validation->run() === FALSE)
        {
            $data = array(
                'referrer' => $this->referrer
            );
            $this->template('common/header,member/register,common/footer', $data);
        }
        else
        {
            $reginfo = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'email'    => $this->input->post('email')
            );
            $uid = $this->Member_model->register($reginfo);
            if ($uid> 0)
            {
                redirect('member/guide');
            }
            else
            {
                redirect('member/register');
            }
        }
    }

    /**
     * 引导页面
     */
    public function guide()
    {
        if( ! ($this->auth->uid> 0))
        {
            redirect();
        }
        $sendparam = encrypt('uid=' . $this->auth->uid . '&email=' . $this->auth->userinfo->email . '&username=' . $this->auth->userinfo->username);
        $sendparam = rawurlencode($sendparam);
        $data['uri']   = site_url("member/sendagain/?s=" . $sendparam);
        $data['email'] = $this->auth->userinfo->email;
        $this->template('common/header,member/guide,common/footer', $data);
    }

    /**
     * email验证
     * 
     * @param string $email
     */
    public function emailcheck($email = '')
    {
        $result = $this->Member_model->emailcheck($email);
        if($result === 1)
        {
            $data['active'] = TRUE;
            $this->template('common/header,tool/index,common/footer', $data);
        }
        else if($result === 2)
        {
            redirect();
        }
        else
        {
            $parse_array  = explode("\t", encrypt($email, 'DECODE'));
            $uid          = ! empty($parse_array[0]) ? (int)$parse_array[0] : 0;
            $email        = ! empty($parse_array[1]) ? $parse_array[1] : '';
            $username     = ! empty($parse_array[2]) ? $parse_array[2] : '';
            $sendparam = encrypt('uid=' . $uid . '&email=' . $email . '&username=' . $username);
            $sendparam = rawurlencode($sendparam);
            $data['uri']   = site_url("member/sendagain/?s=" . $sendparam);
            $this->template('common/header,member/sendmailagain,common/footer', $data);
        }
    }

    /**
     * 重发验证邮件
     */
    public function sendagain()
    {
        try
        {
            $string   = encrypt($this->input->get('s'), 'DECODE');
            parse_str($string);
            if( ! isset($uid, $email, $username))
            {
                throw new Exception('0');
            }
            $send_status = $this->Member_model->check_email_send($uid, $email, $username);
            switch($send_status)
            {
                case '-2':
                    $data = -2;
                    break;
                case '-1':
                    $data = -1;
                    break;
                case '1':
                    $data = 1;
                    break;
                default:
                    $data = 0;
                    break;
            }
            $this->output->set_output($data);
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }

    public function doresetpwd()
    {
        $this->form_validation->set_rules('password', '密码', 'trim|required|matches[passconf]|min_length[3]|max_length[16]');
        $this->form_validation->set_rules('passconf', '重复密码', 'trim|required');
        if($this->form_validation->run() === FALSE)
        {
            $this->template('common/header,member/resetpwd,common/footer');
        }
        else
        {
            $this->template('common/header,member/resetpwd,common/footer');
        }
    }
    
    /**
     * 重设密码页面
     * 
     * @param string $encrypted
     */
    public function resetpwd($encrypted = '')
    {
        if( ! $uid = $this->Member_model->chkresetpwd($encrypted))
        {
            redirect();
        }
        $this->form_validation->set_rules('password', '密码', 'trim|required|matches[passconf]|min_length[3]|max_length[16]');
        $this->form_validation->set_rules('passconf', '重复密码', 'trim|required');
        if($this->form_validation->run() === FALSE)
        {
            $this->template('common/header,member/resetpwd,common/footer');
        }
        else
        {
            $password = $this->input->post('password');
            $res = $this->Member_model->reset_password($uid, $password);
            if($res === 1)
            {
                $data['error_string'] = '<script type="text/javascript">$(function(){showMsgbox("密码重设成功", "success", function(){redirect("member/login")})});</script>';
            }
            else
            {
                $data['error_string'] = '<div class="m10"><span class="c-pink ml60">密码重设失败</span></div>';
            }
            $this->template('common/header,member/resetpwd,common/footer', $data);
        }
    }
    
    /**
     * 找回密码
     */
    public function getpwd()
    {
        $this->form_validation->set_rules('email', '邮箱', 'trim|required|valid_email');
        if($this->form_validation->run() === FALSE)
        {
            $this->template('common/header,member/getpwd,common/footer');
        }
        else
        {
            $data = array();
            $email = $this->input->post('email');
            try
            {
                $res = $this->Member_model->lostpwd_email_send($email);
                if($res === -1)
                {
                    throw new Exception('<span class="c-pink ml60">该邮箱地址未注册，<a href="member/register" class="b">现在注册</a></span>');
                }
                if($res === 0)
                {
                    throw new Exception('<span class="c-pink ml60">发送失败，点击“发送”按钮重新发送</span>');
                }
                $data['error_string'] = '<span class="b ml60">重置密码链接已发送到您的邮箱</span>';
            }
            catch(Exception $e)
            {
                $data['error_string'] = $e->getMessage();
            }
            $this->template('common/header,member/getpwd,common/footer', $data);
        }
    }
    
    /**
     * 修改密码
     */
    public function pwd()
    {
        if ( ! ($this->auth->uid> 0))
        {
            redirect('member/login');
        }
        $this->form_validation->set_rules(
            'password', '当前密码', 'trim|required|min_length[3]|max_length[16]|callback__checkpassword'
        );
        $this->form_validation->set_rules('newpassword', '新密码', 'trim|required|min_length[3]|max_length[16]');

        if ($this->form_validation->run() === FALSE)
        {
            $this->template('common/header,member/pwd,common/footer');
        }
        else
        {
            $res = $this->Member_model->edit(
                array(
                    'uid'         => $this->auth->uid,
                    'password'    => $this->input->post('password'),
                    'newpassword' => $this->input->post('newpassword')
                )
            );
            if ($res === 1)
            {
                $data['error_string'] = '<script type="text/javascript">$(function(){showMsgbox("密码修改成功")});</script>';
            }
            else
            {
                $data['error_string'] = '<script type="text/javascript">$(function(){showMsgbox("密码没有修改", "error")});</script>';
            }
            $this->template('common/header,member/pwd,common/footer', $data);
        }
    }

    /**
     * 头像设置
     */
    public function avatar()
    {
        if ( ! ($this->auth->uid> 0))
        {
            redirect('member/login');
        }
        $this->form_validation->set_rules('x1', '坐标x1', 'trim|required|numeric');
        $this->form_validation->set_rules('x2', '坐标x2', 'trim|required|numeric');
        $this->form_validation->set_rules('y1', '坐标y1', 'trim|required|numeric');
        $this->form_validation->set_rules('y2', '坐标y2', 'trim|required|numeric');

        if ($this->form_validation->run() === FALSE)
        {
            $this->config->load('upload', TRUE);
            $upload_config = $this->config->item('upload');
            $sess_cookie = config_item('cookie_prefix') . config_item('sess_cookie_name');
            $session = json_encode(array(
                $sess_cookie => $this->input->cookie($sess_cookie),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            ));
            
            $data['max_size']      = $upload_config['max_size'];
            $data['allowed_types'] = '*.' . str_replace('|', ';*.', $upload_config['allowed_types']);
            $data['post_params']   = $session;
            
            unset($upload_config, $sess_cookie, $session);
            $this->template('common/header,member/avatar,common/footer', $data);
        }
        else
        {
            $this->load->library('image_lib');
            $this->load->library('avatar');
            $this->avatar->uid = $this->auth->uid;
            $source_image = $this->avatar->avatar_src_full_path();

            if (is_file($source_image))
            {
                $config['source_image']   = $source_image;
                $config['create_thumb']   = TRUE;
                $config['master_dim']     = 'auto';
                $config['x_axis']         = (int)$this->input->post('x1');
                $config['y_axis']         = (int)$this->input->post('y1');
                $config['orig_width']     = (int)abs($this->input->post('x1') - $this->input->post('x2'));
                $config['orig_height']    = (int)abs($this->input->post('y1') - $this->input->post('y2'));
                $config['maintain_ratio'] = FALSE;

                foreach ($this->avatar->avatar_sizes as $presize => $presizename)
                {
                    $config['width'] = $config['height'] = $presize;
                    $config['thumb_marker'] = '_' . $presizename;
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize_crop($config);
                    $this->image_lib->clear();
                }
                @unlink($source_image);
            }
            $data['error_string'] = '<script type="text/javascript">$(function(){showMsgbox("头像修改成功", "success", function(){redirect("member/avatar")})});</script>';
            $this->template('common/header,member/avatar,common/footer', $data);
        }
    }

    /**
     * 帐号设置
     */
    public function setting()
    {
        if ( ! ($this->auth->uid> 0))
        {
            redirect('member/login');
        }
        $this->form_validation->set_rules(
            'username', '用户名', 'trim|required|min_length[3]|max_length[16]|callback__checkusername'
        );
        $this->form_validation->set_rules('city', '城市', 'trim|max_length[80]|regex_match[/^[\x{4e00}-\x{9fa5}]+$/u]');
        $this->form_validation->set_rules(
            'siteurl', '主页',
            'trim|max_length[120]|regex_match[/^(http:\/\/)?[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\’:+!]*([^<>\"])*$/]'
        );
        $this->form_validation->set_rules('signature', '签名', 'trim|max_length[200]');

        $data['profile'] = $this->Member_model->get_profile($this->auth->uid);

        if ($this->form_validation->run() === FALSE)
        {
            $this->template('common/header,member/setting,common/footer', $data);
        }
        else
        {
            list($username, $city, $siteurl, $signature) = array(
                $this->input->post('username'),
                $this->input->post('city'),
                $this->input->post('siteurl'),
                dhtmlspecialchars($this->input->post('signature'))
            );

            $this->Member_model->edit_profile($this->auth->uid, $city, $siteurl, $signature);
            $this->Member_model->edit(array('uid' => $this->auth->uid, 'username' => $username));
            $this->auth->update_userdata(
                array(
                    'username'  => $username,
                    'signature' => $signature
                )
            );
            $data['error_string'] = '<script type="text/javascript">$(function(){showMsgbox("保存成功", "success")});</script>';
            $this->template('common/header,member/setting,common/footer', $data);
        }
    }


    /**
     * 检查用户当前密码是否正确
     *
     * @access public
     * @param $password
     * @return bool
     */
    public function _checkpassword($password)
    {
        $access = $this->Member_model->checkpassword(
            array('uid' => $this->auth->uid, 'password' => $password)
        );
        if ($access <1)
        {
            $this->form_validation->set_message('_checkpassword', '%s不正确');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 检查用户名是否存在
     *
     * @access public
     * @param $username
     * @return bool
     */
    public function _checkusername($username)
    {
        if (
            isset($this->auth->userinfo->username) &&
            $this->auth->userinfo->username &&
            $username == $this->auth->userinfo->username
        )
        {
            return TRUE;
        }
        $access = $this->Member_model->checkname($username);
        switch($access)
        {
            case '-4':
                $this->form_validation->set_message('_checkusername', '%s禁止注册');
                return FALSE;
                break;
            case '-2':
                $this->form_validation->set_message('_checkusername', '%s已经存在');
                return FALSE;
                break;
            case '-1':
                $this->form_validation->set_message('_checkusername', '%s只能为3-16个字的中文、字母、数字和下划线');
                return FALSE;
                break;
            case '1':
                return TRUE;
                break;
        }
        return FALSE;
    }

    /**
     * 检查email是否存在
     *
     * @access public
     * @param $email
     * @return bool
     */
    public function _checkemail($email)
    {
        $access = $this->Member_model->checkemail($email);
        switch($access)
        {
            case '-5':
                $this->form_validation->set_message('_checkemail', '%s长度应该在1-40个字');
                return FALSE;
                break;
            case '-4':
                $this->form_validation->set_message('_checkemail', '%s禁止注册');
                return FALSE;
                break;
            case '-3':
                $this->form_validation->set_message('_checkemail', '%s已经存在');
                return FALSE;
                break;
            case '1':
                return TRUE;
                break;
        }
        return FALSE;
    }
}

//END Index Class

/* End of file index.php */
/* Location: ./application/controllers/member/index.php */