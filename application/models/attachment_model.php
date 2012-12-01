<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * maotin
 *
 * An open source application development framework for PHP 5.3 or newer
 *
 * @package    ${PACKAGE_NAME}
 * @author     <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2010 - 2012, Yzg, Inc.
 * @license    ${LICENSE_LINK}
 * @link       ${PROJECT_LINK}
 * @since      Version ${VERSION} 2012-10-26 下午2:47 $
 * @filesource attachment_model.php
 */

// ------------------------------------------------------------------------

/**
 * 上传文件模型
 *
 * ${CLASS_DESCRIPTION}
 *
 * @package     ${PACKAGE_NAME}
 * @subpackage  ${SUBPACKAGE_NAME}
 * @category    ${CATEGORY_NAME}
 * @author      <yangzhiguo0903@gmail.com>
 * @link        ${FILE_LINK}/attachment_model.php
 */
class Attachment_model extends CI_Model
{
    /**
     * 上传配置
     * @var
     */
    private $upload_config;

    /**
     * 默认返回结构
     * 
     * @var array
     */
    private $data = array(
        'error' => '',
        'result' => array()
    );

    /**
     * 上传域
     */
    const FILE_FIELD = 'Filedata';

    /**
     * 图片文件后缀类型
     */
    public $image_types = array('gif', 'jpg', 'jpeg', 'png', 'jpe');

    public function collect_image($uid = 0, $sources = array(), $descs = array(), $fromnet = 0, $albumid = 0, $origin = '')
    {
        if(empty($sources) || ! is_array($sources))
        {
            return $this->data;
        }
        $this->load->helper('file');
        $this->load->library('image_lib');
        $this->load->model('Image_model');
        $imageid = $success = 0;
        foreach($sources as $skey => $source)
        {
            $source = trim($source);
            if(empty($source))
            {
                continue;
            }

            $content = @file_get_contents($source);
            if( empty($content))
            {
                continue;
            }

            $this->_init_upload_config();
            $size       = strlen($content);
            $pattern    = preg_quote(implode('|', $this->image_types));
            $ext        = preg_replace('/(' . $pattern . ')(.*?)/iU', "\\1", fileext($source));
            $ext        = in_array($ext, $this->image_types) ? $ext : 'jpg';
            $targetname = str_replace('.', '', uniqid($uid, $source)) . '.' . $ext;
            $target     = FCPATH . $this->upload_config['upload_path'] . $targetname;
            if( ! write_file($target, $content))
            {
                continue;
            }
            $imageprop = $this->image_lib->get_image_properties($target, TRUE);
            if( ! isset($imageprop['width']) || ! $imageprop['width'])
            {
                @unlink($target);
                continue;
            }
            $this->_create_thumb($target, $imageprop['width'], $imageprop['height']);

            $depict = $descs[$skey] ? dhtmlspecialchars(mb_substr($descs[$skey], 0, 80)) : '这里是美图一张';

            if($fromnet == '1')
            {
                $collection = 3;
                $origin = $source;
            }
            else
            {
                $collection = 1;
            }
            $ip = $this->input->ip_address();
            $imageid = $this->Image_model->add(
                $albumid, $uid, $ip, $depict, $size, 
                str_replace('\\', '/', $this->upload_config['upload_path']) . $targetname, TIME, $collection, $origin
            );
            $success ++;
        }
        if($success> 0)
        {
            $this->Album_model->update_total_images($albumid, $success);
        }
        $this->data['result']['count']   = $success;
        $this->data['result']['last_imageid'] = $imageid;
        return $this->data;
    }
    
    /**
     * 上传用户头像
     * 
     * @param int $uid
     * @return array
     */
    public function upload_avatar($uid = 0)
    {
        $this->load->library('avatar');
        
        $this->avatar->uid = $uid;
        $_config['upload_path']  = $this->avatar->avatar_path();
        $_config['file_name']    = $this->avatar->avatar_src();
        $_config['encrypt_name'] = FALSE;
        $_config['overwrite']    = TRUE;

        $this->_init_upload_config($_config);
        $this->load->library('upload');
        $this->upload->initialize($this->upload_config);
        $this->upload->do_upload(self::FILE_FIELD);

        if ( ! empty($this->upload->error_msg))
        {
            $this->data['error'] = $this->_eformat($this->upload->error_msg[0]);
            return $this->data;
        }
        $upload_data = $this->upload->data();
        $this->data['result'] = str_replace(str_replace('\\', '/', FCPATH), '', $upload_data['full_path']);
        return $this->data;
    }
    
    /**
     * 本地上传图片
     * 
     * @param int $uid
     * @return array
     */
    public function upload_from_local($uid = 0)
    {   
        $this->_init_upload_config();
        $this->load->library('upload');
        $this->upload->initialize($this->upload_config);
        $this->upload->do_upload(self::FILE_FIELD);

        if ( ! empty($this->upload->error_msg))
        {
            $this->data['error']   = $this->_eformat($this->upload->error_msg[0]);
            return $this->data;
        }

        $this->load->model('Image_model');
        
        $ip          = $this->input->ip_address();
        $upload_data = $this->upload->data();
        $a_path      = str_replace(str_replace('\\', '/', FCPATH), '', $upload_data['full_path']);
        $filesize    = filesize($upload_data['full_path']);
        
        $this->_create_thumb($upload_data['full_path'], $upload_data['image_width'], $upload_data['image_height']);
        $imageid = $this->Image_model->add(0, $uid, $ip, '这里是美图一张', $filesize, $a_path, TIME, 2);
        $this->data['result'] = array(
            'path' => $a_path,
            'imageid' => $imageid
        );
        return $this->data;
    }

    /**
     * 初始化上传配置信息
     * 
     * @param array $custom_config
     * @return bool
     */
    public function _init_upload_config($custom_config = array())
    {
        $this->load->helper('filei');
        $this->config->load('upload', TRUE);
        $this->upload_config = empty($custom_config) ? 
                               $this->config->item('upload') : 
                               array_merge($this->config->item('upload'), $custom_config);
        dmkdir(FCPATH . $this->upload_config['upload_path']);
        return TRUE;
    }
    
    /**
     * 创建缩略图
     * 
     * @param string $full_path
     * @param int $image_width
     * @param int $image_height
     * @return bool
     */
    public function _create_thumb($full_path = '', $image_width = 0, $image_height = 0)
    {
        try
        {
            soft_resize_cut($full_path, $image_width, $image_height, 102, 85);
            soft_resize_cut($full_path, $image_width, $image_height, 226, 188);
            return TRUE;
        }
        catch(Exception $e)
        {
            return FALSE;
        }
    }

    /**
     * 上传错误提示
     *
     * @param string $err_msg
     * @return string
     */
    private function _eformat($err_msg = '')
    {
        $errors = array(
            'upload_no_file_selected'        => '没有选择文件',
            'upload_file_exceeds_limit'      => '文件的大小超过限制',
            'upload_file_exceeds_form_limit' => '文件的大小超过限制',
            'upload_file_partial'            => '文件只有部分上传',
            'upload_no_temp_directory'       => '没有缓存目录',
            'upload_unable_to_write_file'    => '无法写入文件',
            'upload_stopped_by_extension'    => '上传被中止',
            'upload_invalid_filetype'        => '文件类型无效',
            'upload_invalid_filesize'        => '文件尺寸过大',
            'upload_invalid_dimensions'      => '图片尺寸无效',
            'upload_destination_error'       => '无法上传文件',
            'upload_bad_filename'            => '文件名损坏',
            'upload_no_file_types'           => '文件没有类型',
            'upload_no_filepath'             => '文件路径无效',
            'upload_not_writable'            => '文件无法写入'
        );
        return isset($errors[$err_msg]) ? $errors[$err_msg] : $err_msg;
    }
}
// END ${CLASS_NAME} class

/* End of file attachment_model.php */
/* Location: ${FILE_PATH}/attachment_model.php */