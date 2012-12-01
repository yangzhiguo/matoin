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
 * @version    $Id: admincp.php 1193 2012-02-18 22:42 $
 */

// ------------------------------------------------------------------------

/**
 * 管理台
 *
 * @package     Maotin
 * @subpackage  Controllers
 * @category    Admincp-Controllers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */
class Admincp extends MT_admincp
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('number');
        $this->load->model('Setting_model');
    }

    /**
     * 管理面板初始化
     * @return NULL
     */
    public function index()
    {
        $data = array(
            'system_info' => $this->_system_info()
        );
        $this->load->view('admincp/header');
        $this->load->view('admincp/index', $data);
        $this->load->view('admincp/footer');
    }

    /**
     * 管理面板首页
     * @return NULL
     */
    public function home()
    {
        $data = array(
            'system_info' => $this->_system_info()
        );
        $this->load->view('admincp/index', $data);
    }

    /**
     * 上传设置
     * @return NULL
     */
    public function attach()
    {
        $this->form_validation->set_rules('setting[attachdir]', '附件路径', 'required');
        $this->form_validation->set_rules('setting[attachurl]', '附件URL', 'required');
        $this->form_validation->set_rules('setting[thumbquality]', '缩略图质量', 'required|greater_than[-1]|less_than[101]');

        if ( ! $this->form_validation->run())
        {
            if ($this->input->post('ajx') == 1)
            {
                $this->output->set_output('请按照每个字段后规范填写');
            }
            else
            {
                $data = unserialize($this->Setting_model->get('attach'));
                $this->load->view('admincp/attach', $data);
            }
        }
        else
        {
            $setting = $this->input->post('setting');
            $this->Setting_model->set('attach', serialize($setting));
            $this->output->set_output('保存成功');
        }
    }

    /**
     * 进阶上传设置
     * @return NULL
     */
    public function ftp()
    {
        $this->form_validation->set_rules('setting[ftpon]', '是否开启远程附件', 'required');
        if ( ! $this->form_validation->run())
        {
            if ($this->input->post('ajx') == 1)
            {
                $this->output->set_output('请按照每个字段后规范填写');
            }
            else
            {
                $data = unserialize($this->Setting_model->get('ftp'));
                $this->load->view('admincp/ftp', $data);
            }
        }
        else
        {
            $setting = $this->input->post('setting');
            $this->Setting_model->set('ftp', serialize($setting));
            $this->output->set_output('保存成功');
        }
    }

    /**
     * 获取版本及服务器信息
     *
     * @return array
     */
    public function _system_info()
    {
        $data = array();
        @$GD = gd_info();
        $data['php_version']          = PHP_OS . '/PHP' . PHP_VERSION;
        $data['server_software']      = $_SERVER['SERVER_SOFTWARE'];
        $data['server_port']          = $_SERVER['SERVER_PORT'];
        $data['http_accept_language'] = getenv("HTTP_ACCEPT_LANGUAGE");
        $data['mysql_version']        = mysql_get_server_info();
        $data['disk_free_space']      = function_exists('disk_free_space') ? byte_format(disk_free_space('.')) : '未知';
        $data['gd']                   = function_exists('imagecreate') ? $GD['GD Version'] : '不支持GD库';
        $data['safe_mode']            = ini_get('safe_mode') ? '是' : '否';
        $data['register_globals']     = ini_get('register_globals') ? '打开' : '关闭';
        $data['magic_quotes_gpc']     = get_magic_quotes_gpc() ? '打开' : '关闭';
        $data['post_max_size']        = ini_get('post_max_size');
        $data['upload_max_filesize']  = ini_get('upload_max_filesize');
        $data['allow_url_fopen']      = ini_get('allow_url_fopen') ? '支持' : '不支持';
        $data['execution_time']       = ini_get('max_execution_time') . '秒';
        return $data;
    }
}

//END Admincp Class

/* End of file admincp.php */
/* Location: ./application/admincp/admincp.php */