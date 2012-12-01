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
 * @since      Version ${VERSION} 2012-08-13 下午5:22 $
 * @filesource tag.php
 */

// ------------------------------------------------------------------------

/**
 * tag
 *
 * ${CLASS_DESCRIPTION}
 *
 * @package     ${PACKAGE_NAME}
 * @subpackage  ${SUBPACKAGE_NAME}
 * @category    ${CATEGORY_NAME}
 * @author      <yangzhiguo0903@gmail.com>
 * @link        ${FILE_LINK}/tag.php
 */

class Tag extends MT_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tag_model');
        $this->load->model('Image_model');
    }

    /**
     * 标签首页
     */
    public function index()
    {
        $this->load->library('pagination');

        $pagesize = 200;
        $config['base_url']   = base_url('tag');
        $config['total_rows'] = $this->Tag_model->total_rows();
        $config['per_page']   = $pagesize;
        $this->pagination->initialize($config);
        $offset = (int)$this->input->get($this->pagination->query_string_segment);

        $data['page'] = $this->pagination->create_links();
        $data['tag'] = $this->Tag_model->get_all_tag($pagesize, ($offset - 1) * $pagesize);
        $this->template('common/header,content/tag,common/footer', $data);
    }

    /**
     * 标签内容页
     */
    public function tag_content($tagid = 0)
    {
        $this->load->library('pagination');

        $pagesize = 12;
        $offset = (int)$this->input->get($this->pagination->query_string_segment);
        $tag_profile = $this->Tag_model->get_tag_profile($tagid, $pagesize, ($offset - 1) * $pagesize);
        
        $config['base_url']   = base_url('tag/' . $tagid);
        $config['total_rows'] = $tag_profile['images'];
        $config['per_page']   = $pagesize;
        $this->pagination->initialize($config);
        $data['page']        = $this->pagination->create_links();
        $data['tag_profile'] = $tag_profile;
        $this->template('common/header,content/tag_content,common/footer', $data);
    }
    /**
     * 删除标签
     * 
     * @param int $tagid
     * @param int $itemid
     * @throws Exception
     */
    public function delete($tagid = 0, $itemid = 0)
    {
        try
        {
            if( ! ($this->auth->uid> 0))
            {
                throw new Exception('-1');
            }
            if( ! $this->Image_model->image_exists($itemid))
            {
                throw new Exception('-3');
            }
            $uid = $this->Image_model->image_exists($itemid, $this->auth->uid) ? NULL : $this->auth->uid;
            $result = $this->Tag_model->delete_item_tag($tagid, $itemid, 'image', $uid);
            if( ! $result)
            {
                throw new Exception('-2');
            }
            $this->output->set_output('1');
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }

    /**
     * 贴上标签
     * 
     * @throws Exception
     */
    public function add()
    {
        try
        {
            if( ! ($this->auth->uid> 0))
            {
                throw new Exception('-1');
            }
            $result = array();
            $this->load->library('form_validation');

            $this->form_validation->set_rules('tag', '标签', 'trim|required|min_length[1]');
            $this->form_validation->set_rules('imageid', '图片id', 'trim|required|is_natural');
            if ($this->form_validation->run() === FALSE)
            {
                throw new Exception('-3');
            }
            else
            {
                $tag     = $this->input->post('tag');
                $imageid = (int)$this->input->post('imageid');
                if( ! $this->Image_model->image_exists($imageid))
                {
                    throw new Exception('-4');
                }

                $taglist = array_unique(
                    array_filter(
                        explode(',', str_replace(array('，', ','), ',', $tag))
                    )
                );

                if($taglist)
                {
                    foreach($taglist as $eachtag)
                    {
                        $tagid = 0;
                        $eachtag   = dhtmlspecialchars(mb_substr($eachtag, 0, 16));
                        if($tagid = $this->Tag_model->set_tag($eachtag, $this->auth->uid, $imageid, 'image'))
                        {
                            $result[] = array('id' => $tagid, 'tag' => $eachtag);
                        }
                    }
                    $this->output->set_output(json_encode($result));
                }
                else
                {
                    throw new Exception('-2');
                }
            }
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }
}

// END Tag class

/* End of file tag.php */
/* Location: ${FILE_PATH}/tag.php */