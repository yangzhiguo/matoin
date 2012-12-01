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
 * @since      Version ${VERSION} 2012-08-31 下午9:28 $
 * @filesource reload_cookie.php
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
 * @link        ${FILE_LINK}/reload_cookie.php
 */

class Reload_cookie
{
    /**
     * @return bool
     */
    public function reloadcookie()
    {
        $sess_cookie = config_item('cookie_prefix') . config_item('sess_cookie_name');
        $csrf_cookie = config_item('cookie_prefix') . config_item('csrf_cookie_name');

        if(
            isset($_POST[$sess_cookie]) &&
            $_POST[$sess_cookie] &&
            isset($_POST[$csrf_cookie]) &&
            $_POST[$csrf_cookie]
        )
        {
            $_COOKIE[$sess_cookie] = $_POST[$sess_cookie];
            $_COOKIE[$csrf_cookie] = $_POST[$csrf_cookie];
        }
        unset($sess_cookie, $csrf_cookie);
        return TRUE;
    }
}

// END ${CLASS_NAME} class

/* End of file reload_cookie.php */
/* Location: ${FILE_PATH}/reload_cookie.php */