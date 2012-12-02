<?php defined('BASEPATH') or exit('No direct script access allowed');
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
 * @version    $Id album.php v1.0.0 2012-01-19 05:21 $
 */

// ------------------------------------------------------------------------

/**
 * 专辑
 *
 * @package     matoin
 * @subpackage  Controllers
 * @category    Front-controllers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class Album extends MT_Controller
{
    /**
     *
     * @var object
     */
    public $Album_model;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Album_model');
        $this->load->model('Image_model');
        $this->load->library('form_validation');
        $this->load->helper('date');
    }

    /**
     * 专辑首页
     *
     * @param $albumid
     */
    public function index($albumid)
    {
        $albumid = (int)$albumid;
        if( ! ($albumid> 0))
        {
            redirect('');
        }
        $albuminfo = $this->Album_model->get_album($albumid);
        if(empty($albuminfo))
        {
            redirect('');
        }

        $this->load->library('pagination');
        $pagesize = 15;
        $config['base_url']   = base_url('album/' . $albumid);
        $config['total_rows'] = (int)$albuminfo->images;
        $config['per_page']   = $pagesize;
        $this->pagination->initialize($config);
        $offset = (int)$this->input->get($this->pagination->query_string_segment);

        $data['page']       = $this->pagination->create_links();
        $data['piclist']    = $this->Image_model->get_album_image($albumid, $pagesize, ($offset - 1) * $pagesize, $this->auth->uid);
        $data['albuminfo']  = $albuminfo;

        $this->template('common/header,album/album_contents,common/footer', $data);
    }

    /**
     * 编辑专辑信息
     *
     * @param int $albumid
     */
    public function edit($albumid)
    {
        if ( ! ($this->auth->uid> 0))
        {
            redirect('member/login');
        }

        $albumid = (int)$albumid;
        if( ! ($albumid> 0))
        {
            redirect('member/' . $this->auth->uid . '/albums');
        }
        $albuminfo = $this->Album_model->get_album($albumid);
        if(empty($albuminfo) || $albuminfo->uid != $this->auth->uid)
        {
            redirect('member/' . $this->auth->uid . '/albums');
        }
        $data['albuminfo']  = $albuminfo;

        $this->form_validation->set_rules('name', '专辑名', 'trim|required|min_length[1]|max_length[16]');  //专辑名16,存储最大值96
        $this->form_validation->set_rules('depict', '专辑描述', 'trim|max_length[200]');  //专辑最大字数200,存储最大值1200
        if ($this->form_validation->run() === FALSE)
        {
            $this->template('common/header,album/edit,common/footer', $data);
        }
        else
        {
            $albumname = dhtmlspecialchars($this->input->post('name'));
            $depict    = dhtmlspecialchars($this->input->post('depict'));

            $result = $this->Album_model->edit($this->auth->uid, $albumid, $albumname, $depict);
            if($result === 1)
            {
                $data['error_string'] = '<script type="text/javascript">$(function(){showMsgbox("保存成功")});</script>';
                $data['albuminfo'] = $this->Album_model->get_album($albumid);
            }
            else
            {
                $data['error_string'] = '<script type="text/javascript">$(function(){showMsgbox("专辑名已存在", "error")});</script>';
            }
            $this->template('common/header,album/edit,common/footer', $data);
        }
    }

    /**
     * 增加一个专辑
     */
    public function add()
    {
        if ( ! ($this->auth->uid> 0))
        {
            redirect('member/login');
        }
        $this->form_validation->set_rules('newalbumname', '专辑名', 'trim|required|min_length[1]|max_length[16]');
        $this->form_validation->set_rules('description', '专辑描述', 'trim|max_length[200]');
        if ($this->form_validation->run() !== FALSE)
        {
            $albumname = dhtmlspecialchars($this->input->post('newalbumname'));

            $albumid = $this->Album_model->add(
                $this->auth->uid,
                $albumname
            );
            if($this->input->post('ajx') == 1)
            {
                if( ! $albumid)
                {
                    $this->output->set_output('0');
                }
                else
                {
                    $this->output->set_output('<a href="javascript:void(0);" title="单击选择专辑" alt="' . $albumid . '" onclick="selectalbumid(' . $albumid . ', this);return false;">' . $albumname . '</a>');
                }
            }
            else
            {
                if($albumid)
                {
                    $data['error_string'] = '<script type="text/javascript">$(function(){showMsgbox("创建成功", \'success\', function(){redirect(\'member/' . $this->auth->uid . '/albums\')})});</script>';
                }
                else
                {
                    $data['error_string'] = '<script type="text/javascript">$(function(){showMsgbox("专辑名已存在", \'error\')});</script>';
                }
                $this->template('common/header,album/add,common/footer', $data);
            }
        }
        else
        {
            if($this->input->post('ajx') == 1)
            {
                $this->output->set_output('<span>专辑名太长了</span>');
            }
            else
            {
                $this->template('common/header,album/add,common/footer');
            }
        }
    }

    /**
     * 删除一个专辑
     *
     * @param int $albumid
     */
    public function delete($albumid)
    {
        if ( ! ($this->auth->uid> 0))
        {
            redirect('member/login');
        }
        $albumid = (int)$albumid;
        if( ! ($albumid> 0))
        {
            redirect('member/' . $this->auth->uid . '/albums');
        }
        if($this->auth->uid == $this->Album_model->album_owner($albumid))
        {
            $res = $this->Album_model->remove_album($albumid, $this->auth->uid);
            $this->output->set_output($res);
        }
        else
        {
            redirect('member/' . $this->auth->uid . '/albums');
        }
    }

    /**
     * 设置专辑图片
     * 
     * @throws Exception
     */
    public function setcover()
    {
        try
        {
            if( ! ($this->auth->uid> 0))
            {
                throw new Exception('-1');  //未登录
            }
            $albumid = (int)$this->input->get('albumid');
            $imageid = (int)$this->input->get('imageid');
            if($albumid <=0 || $imageid <=0)
            {
                throw new Exception('-2');  //参数不合法
            }
            if($this->auth->uid != $this->Album_model->album_owner($albumid))
            {
                throw new Exception('-3');  //不是自己的专辑
            }
            $this->load->model('Image_model');
            if( ! $this->Image_model->image_exists($imageid, $this->auth->uid))
            {
                throw new Exception('-4');  //不是自己的图片
            }
            $affected = $this->Album_model->setcoverpic($albumid, $imageid);
            if( ! $affected)
            {
                throw new Exception('0');
            }
            $this->output->set_output('1');
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }
}

//END Album Class

/* End of file album.php */
/* Location: ./application/controllers/album/album.php */