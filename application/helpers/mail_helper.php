<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * matoin
 *
 * An open source application development framework for PHP 5.3 or newer
 *
 * @package    ${PACKAGE_NAME}
 * @author     <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2010 - 2012, Yzg, Inc.
 * @license    ${LICENSE_LINK}
 * @link       ${PROJECT_LINK}
 * @since      Version ${VERSION} 2012-10-24 下午12:58 $
 * @filesource email_helper.php
 */

// ------------------------------------------------------------------------

/**
 * 发送验证邮件
 * 
 * @param string $to
 * @param string $username
 * @param string $link
 * @param string $template {chkemail|lostpwd} 模版
 * @return mixed
 */
if( ! function_exists('sendmail'))
{
    function sendmail($to = '', $username = '', $link = '', $template = 'chkemail')
    {
        $CI =& get_instance();
        $CI->load->library('email');
        $CI->config->load('email', TRUE);
        $CI->lang->load('email', 'zh-cn');
        $email_config = $CI->config->item('email');
        
        $CI->email->from($email_config['smtp_user'], $CI->lang->line('email_tpl_from_name'));
        $CI->email->to($to);
        $CI->email->subject($CI->lang->line($template . '_tpl_title'));
        $CI->email->message(sprintf($CI->lang->line($template . '_tpl_content'), $username, $link, $link));
        $send_status = $CI->email->send();
        return $send_status;
    }
}

/* End of file email_helper.php */
/* Location: ${FILE_PATH}/email_helper.php */