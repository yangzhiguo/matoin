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
 * @since      Version ${VERSION}
 * @filesource member.php
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
 * @link        ${FILE_LINK}/member.php
 */

class member extends MT_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 会员主页
     * 说明:{memberinfo:任一会员的基本信息,userinfo:当前登录用户的信息}
     *
     * @param int $uid
     */
    public function home($uid = 0)
    {
        if ( ! ($uid> 0))
        {
            redirect();
        }
        $data = array();
        $uid = (int)$uid;

        $data['memberinfo'] = $this->Member_model->getuserinfo(array('uid' => $uid));
        if(!is_object($data['memberinfo']) && $data['memberinfo'] == -1)
        {
            redirect();
        }

        $total_rows = (int)$this->Member_model->get_member_count($uid, 'images')->images;

        if($total_rows> 0)
        {
            $this->load->library('pagination');
            $this->load->model('Image_model');

            $pagesize = 15;
            $config['base_url']   = base_url('member/' . $uid);
            $config['total_rows'] = $total_rows;
            $config['per_page']   = $pagesize;

            $this->pagination->initialize($config);
            $offset = (int)$this->input->get($this->pagination->query_string_segment);

            $data['page'] = $this->pagination->create_links();
            $data['piclist'] = $this->Image_model->get_user_fave_image($uid, $pagesize, ($offset - 1) * $pagesize);
        }
        $this->template('common/header,member/home,common/footer', $data);
    }

    /**
     * 用户专辑首页
     *
     * @param $uid
     */
    public function albums($uid)
    {
        if ( ! ($uid> 0))
        {
            redirect();
        }
        $data = array();
        $uid = (int)$uid;

        $data['memberinfo'] = $uid == $this->auth->uid
                            ?
                            $this->auth->userinfo
                            :
                            $this->Member_model->getuserinfo(array('uid' => $uid));
        if( ! $data['memberinfo'])
        {
            redirect();
        }

        $total_rows = (int)$this->Member_model->get_member_count($uid, 'albums')->albums;
        if($total_rows> 0)
        {
            $this->load->model('Album_model');
            $this->load->library('pagination');
            $pagesize = 12;
            $config['base_url']   = base_url('member/' . $uid . '/albums');
            $config['total_rows'] = $total_rows;
            $config['per_page']   = $pagesize;

            $this->pagination->initialize($config);
            $offset = (int)$this->input->get($this->pagination->query_string_segment);

            $data['page'] = $this->pagination->create_links();
            $data['listinfo']   = $this->Album_model->get_albums($uid, $pagesize, ($offset - 1) * $pagesize);
        }
        $data['total_rows'] = $total_rows;
        $this->template('common/header,album/list,common/footer', $data);
    }
}

// END ${CLASS_NAME} class

/* End of file member.php */
/* Location: ${FILE_PATH}/member.php */
