<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ${PROJECT_NAME}
 *
 * An open source application development framework for PHP 5.3 or newer
 *
 * @package    ${PACKAGE_NAME}
 * @author     <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2010 - 2012, Yzg, Inc.
 * @license    ${LICENSE_LINK}
 * @link       ${PROJECT_LINK}
 * @since      Version ${VERSION} 2012-08-10 上午12:22 $
 * @filesource image.php
 */

// ------------------------------------------------------------------------

/**
 * ${CLASS_NAME}
 *
 * ${CLASS_DESCRIPTION}
 *
 * @package     ${PACKAGE_NAME}
 * @subpackage  ${SUBPACKAGE_NAME}
 * @category    ${CATEGORY_NAME}
 * @author      <yangzhiguo0903@gmail.com>
 * @link        ${FILE_LINK}/image.php
 */

class Image extends MT_Controller
{
    /**
     * 收藏/取消收藏
     * 
     * @throws Exception
     */
    public function fave_toggle()
    {
        try
        {
            if ( ! ($this->auth->uid> 0))
            {
                throw new Exception('<p>请先登录</p>');
            }
            $imageid = (int)$this->input->get('imageid');
            if( ! ($imageid> 0))
            {
                throw new Exception('<p>图片不存在</p>');
            }
            $this->load->model('Image_model');
            $fave_or_not = $this->Image_model->fava_or_not(array($imageid));
            $fave_func = empty($fave_or_not) ? 'fave_image' : 'unfave_image';
            $affected = $this->Image_model->$fave_func($imageid, $this->auth->uid);
            
            if( ! $affected)
            {
                throw new Exception('<p>收藏失败</p>');
            }
            $this->output->set_output(empty($fave_or_not) ? '1' : '2');
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }
    
    /**
     * 编辑图片描述
     *
     * @throws Exception
     */
    public function edit()
    {
        try
        {
            if ( ! ($this->auth->uid> 0))
            {
                throw new Exception('<p>请先登录</p>');
            }

            $this->load->library('form_validation');

            $this->form_validation->set_rules('imageid', '图片id', 'trim|required|is_natural');
            $this->form_validation->set_rules('depict', '图片描述', 'trim|required|min_length[1]|max_length[80]');
            if ($this->form_validation->run() === FALSE)
            {
                $error = $this->form_validation->error('imageid') ? $this->form_validation->error('imageid') : $this->form_validation->error('depict');
                throw new Exception($error);
            }
            else
            {
                $imageid = (int)$this->input->post('imageid');
                $depict  = $this->input->post('depict');
                $depict  = dhtmlspecialchars($depict);

                $this->load->model('Image_model');
                $imageinfo = $this->Image_model->get_image($imageid);
                if( ! $imageinfo || $imageinfo->uid != $this->auth->uid)
                {
                    throw new Exception('<p>只能修改自己发布的图片</p>');
                }
                if($depict == $imageinfo->depict)
                {
                    throw new Exception('<p>描述未修改</p>');
                }
                $affected_rows = $this->Image_model->set_image_albuminfo(
                    array('depict' => $depict),
                    array('imageid' => $imageid)
                );
                if( ! $affected_rows)
                {
                    throw new Exception('<p>描述修改失败</p>');
                }
                $this->output->set_output('1');
            }
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }
}

// END ${CLASS_NAME} class

/* End of file image.php */
/* Location: ${FILE_PATH}/image.php */