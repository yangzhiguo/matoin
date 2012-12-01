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
 * @since      Version ${VERSION} 2012-08-03 下午9:22 $
 * @filesource avatar_helper.php
 */

// ------------------------------------------------------------------------

/**
 * 取用户头像地址
 *
 * @param int $uid
 * @param string $size
 * @return string
 */
if( ! function_exists('avatar_uri'))
{
    function avatar_uri($uid, $size = 'middle')
    {
        static $avatars = array();
        if(isset($avatars[$uid][$size]))
        {
            return $avatars[$uid][$size];
        }
        $CI =& get_instance();
        $CI->load->library('avatar');
        $avatars[$uid] = $CI->avatar->avatar_uri($uid);
        return $avatars[$uid][$size];
    }
}

/* End of file avatar_helper.php */
/* Location: ${FILE_PATH}/avatar_helper.php */
