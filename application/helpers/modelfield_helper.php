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
 * @since      Version ${VERSION} 2012-09-09 上午9:54 $
 * @filesource modelfield_helper.php
 */

// ------------------------------------------------------------------------

/**
 * ajx添加专辑模版
 *
 * @param int $uid
 * @param string $inputid
 * @return string
 */
if( ! function_exists('album_modelfield'))
{
    function album_modelfield($uid, $inputid)
    {
        $CI = & get_instance();
        $CI->load->model('Album_model');
        $data['myalbums'] = $CI->Album_model->get_albums($uid);
        $data['inputid'] = $inputid;
        return $CI->load->view('album/album_modelfield', $data, TRUE);
    }
}

// ------------------------------------------------------------------------

/**
 * 个人模块模版
 *
 * @param int $uid
 * @return string
 */
if( ! function_exists('member_modelfield'))
{
    function member_modelfield($uid = 'default')
    {
        $CI = & get_instance();
        $data = array();
        if($uid === 'default')
        {
            $data['memberinfo'] = $CI->auth->userinfo;
            $data['member_count'] = $CI->Member_model->get_member_count($CI->auth->uid, 'albums,images');
        }
        else
        {
            $data['memberinfo'] = $CI->Member_model->getuserinfo(array('uid' => $uid));
            $data['member_count'] = $CI->Member_model->get_member_count($uid, 'albums,images');
        }
        return $CI->load->view('member/setmenu', $data, TRUE);
    }
}

/* End of file modelfield_helper.php */
/* Location: ${FILE_PATH}/modelfield_helper.php */