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
 * @since      Version ${VERSION} 2012-10-15 上午11:41 $
 * @filesource email.php
 */

// ------------------------------------------------------------------------
$config['protocol']     = 'smtp';
$config['smtp_host']    = 'smtp.ym.163.com'  ;//	无默认值	无	SMTP 服务器地址。
$config['smtp_user']    = 'admin@matoin.com';  //	无默认值	无	SMTP 用户账号。
$config['smtp_pass']    = 'matoin/xiaozhi3';  //	无默认值	无	SMTP 密码。
$config['smtp_port']    = 25;  //	无	SMTP 端口。
$config['smtp_timeout'] = 5; //	无	SMTP 超时设置(单位：秒)。
$config['mailtype']     = 'html';
$config['charset']      = 'utf-8';
$config['wordwrap']     = TRUE;

/* End of file email.php */
/* Location: ${FILE_PATH}/email.php */