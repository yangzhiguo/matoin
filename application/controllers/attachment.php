<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Maotin System
 *
 * 猫头鹰Maotin - 帮你寻找最有价值的东西
 *
 * Maotin - to help you find the most valuable thing
 *
 * @package    Maotin
 * @author     yzg <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2011 - 2012, maotin.com.
 * @license    GNU General Public License 2.0
 * @link       http://www.maotin.com/
 * @version    $Id attachment.php v1.0.0 2012-01-19 05:21 $
 */

// ------------------------------------------------------------------------

/**
 * 附件上传
 *
 * @package     Maotin
 * @subpackage  Controllers
 * @category    Front-controllers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */
class Attachment extends MT_Controller
{
    /**
     * swfupload 上传本地图片
     *
     * @throws Exception
     */
    public function uploadfromlocal()
    {
        try
        {
            if ( ! ($this->auth->uid> 0))
            {
                throw new Exception('ERROR:请登录');
            }
            $this->load->model('Attachment_model');
            $result = $this->Attachment_model->upload_from_local($this->auth->uid);
            if( ! empty($result['error']))
            {
                throw new Exception('ERROR:' . $result['error']);
            }
            $this->output->set_output('FILEID:' . json_encode(array(site_url() . $result['result']['path'], $result['result']['imageid'])));
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }

    /**
     * 把上传的图片放入专辑
     *
     * @throws Exception
     */
    public function collect_album()
    {
        try
        {
            if ( ! ($this->auth->uid> 0))
            {
                $stat['sta'] = -1;
                $stat['msg'] = '请先登录';
                throw new Exception(json_encode($stat));
            }

            $this->load->library('form_validation');
            $this->load->model('Album_model');
            $this->load->model('Image_model');

            $this->form_validation->set_rules('imageid', '图片', 'trim|required|integer');
            if ($this->form_validation->run() === FALSE)
            {
                $stat['sta'] = -2;
                $stat['msg'] = '请先上传一张图片';
                throw new Exception(json_encode($stat));
            }

            $albumid = (int)$this->input->post('albumid');
            $imageid = (int)$this->input->post('imageid');
            $depict  = trim($this->input->post('desc'));
            $depict = $depict ? dhtmlspecialchars(mb_substr($depict, 0, 80)) : '这里是美图一张';

            if($albumid <=0)
            {
                $stat['sta'] = -2;
                $stat['msg'] = '请选择一张专辑';
                throw new Exception(json_encode($stat));
            }
            if($albumid> 0 && $this->auth->uid != $this->Album_model->album_owner($albumid))
            {
                $stat['sta'] = -2;
                $stat['msg'] = '只能选择自己的专辑';
                throw new Exception(json_encode($stat));
            }
            if( ! $this->Image_model->image_exists($imageid, $this->auth->uid))
            {
                $stat['sta'] = -3;
                $stat['msg'] = '图片不存在';
                throw new Exception(json_encode($stat));
            }
            $reqdata['albumid'] = $albumid;
            $this->Album_model->update_total_images($albumid, 1);
            $reqdata['depict'] = $depict;
            $this->Image_model->set_image_albuminfo($reqdata, array('imageid' => $imageid));
            $stat = array(
                'sta' => 1,
                'msg' => site_url('view/' . $imageid)
            );
            $this->output->set_output(json_encode($stat));
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }

    /**
     *
     * 存储发布的图片
     *
     * @return void {-3:系统错误,请与管理员联系,-2:需要选择一个专辑,-1:需要登录,0:没有得到图片,n:得到图片,返回专辑id}
     * @throws Exception
     */
    public function collect()
    {
        try
        {
            if ( ! ($this->auth->uid> 0))
            {
                $stat['sta'] = -1;
                $stat['msg'] = '请先登录';
                throw new Exception(json_encode($stat));
            }
            $this->load->library('form_validation');
            $this->form_validation->set_rules('imgurl', '图片', 'required');
            if ($this->form_validation->run() !== FALSE)
            {
                ignore_user_abort(TRUE);
                $sources = $this->input->post('imgurl');
                $origin  = trim($this->input->post('origin'));
                $fromnet = $this->input->post('fromnet');
                $descs   = $this->input->post('desc');
                $albumid = (int)$this->input->post('albumid');

                if(empty($sources))
                {
                    $stat['sta'] = -4;
                    $stat['msg'] = '远程图片不存在';
                    throw new Exception(json_encode($stat));
                }
                if($albumid <=0)
                {
                    $stat['sta'] = -2;
                    $stat['msg'] = '请选择一张专辑';
                    throw new Exception(json_encode($stat));
                }
                $this->load->model('Album_model');
                if($this->auth->uid != $this->Album_model->album_owner($albumid))
                {
                    $stat['sta'] = -2;
                    $stat['msg'] = '只能选择自己的专辑';
                    throw new Exception(json_encode($stat));
                }
                $this->load->model('Attachment_model');
                $res = $this->Attachment_model->collect_image( $this->auth->uid, $sources, $descs, $fromnet, $albumid, $origin);
                $count = isset($res['result']['count']) ? $res['result']['count'] : 0;
                if($count == 0)
                {
                    $stat['sta'] = 0;
                    $stat['msg'] = '无法得到远程图片';
                    throw new Exception(json_encode($stat));
                }
                $url = $count == 1 ? site_url('view/' . $res['result']['last_imageid']) : site_url('album/' . $albumid);
                $stat = array(
                    'sta' => 1,
                    'msg' => $url
                );
                $this->output->set_output(json_encode($stat));
            }
            else
            {
                $stat['sta'] = -4;
                $stat['msg'] = '无法得到远程图片';
                throw new Exception(json_encode($stat));
            }
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }

    /**
     * swfupload上传头像
     */
    public function avatar()
    {
        try
        {
            if ( ! ($this->auth->uid> 0))
            {
                throw new Exception('ERROR:请登录');
            }
            $this->load->model('Attachment_model');
            $result = $this->Attachment_model->upload_avatar($this->auth->uid);
            if( ! empty($result['error']))
            {
                throw new Exception('ERROR:' . $result['error']);
            }
            $this->output->set_output('FILEID:' . site_url() . $result['result']);
        }
        catch (Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }
}
//END Attachment Class

/* End of file attachment.php */
/* Location: ./application/controllers/attachment/attachment.php */