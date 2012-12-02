<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * matoin System
 *
 * 猫头鹰matoin - 帮你寻找最有价值的东西
 *
 * matoin - to help you find the most valuable thing
 *
 * @package    matoin
 * @author     yzg <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2011 - 2012, matoin.com.
 * @license    GNU General Public License 2.0
 * @link       http://www.matoin.com/
 * @version    $Id upload.php v1.0.0 2012-01-08 03:50 $
 */

// ------------------------------------------------------------------------

/**
 * 附件上传配置文件
 *
 * @package     matoin
 * @subpackage  Controllers
 * @category    Front-controllers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
$config['max_size']      = '2048';
$config['allowed_types'] = 'jpg|png|gif|jpeg';
$config['upload_path']   = 'data' . DIRECTORY_SEPARATOR . 'a' . DIRECTORY_SEPARATOR . date('Ym', TIME) . DIRECTORY_SEPARATOR . date('d', TIME) . DIRECTORY_SEPARATOR;
$config['overwrite']     = FALSE;
$config['encrypt_name']  = TRUE;
$config['remove_spaces'] = TRUE;
$config['xss_clean']     = TRUE;
$config['temp_prefix']   = 'mt_tmpfile_';

/* End of file upload.php */
/* Location: ./application/config/upload.php */