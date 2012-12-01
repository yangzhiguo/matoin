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
 * @since      Version ${VERSION} 2012-08-05 上午12:10 $
 * @filesource pagination.php
 */

// ------------------------------------------------------------------------

$config['page_query_string']    = TRUE;
$config['query_string_segment'] = 'p';
$config['use_page_numbers']     = TRUE;

$config['per_page']      = 15;
$config['num_links']     = 3;
$config['first_link']    = '&laquo;';
$config['last_link']     = '&raquo;';
$config['prev_link']     = FALSE;
$config['next_link']     = FALSE;
$config['cur_tag_open']  = '&nbsp;<span>';
$config['cur_tag_close'] = '</span>';

/* End of file pagination.php */
/* Location: ${FILE_PATH}/pagination.php */
