<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * maotin-sae
 *
 * An open source application development framework for PHP 5.3 or newer
 *
 * @package    ${PACKAGE_NAME}
 * @author     <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2010 - 2012, Yzg, Inc.
 * @license    ${LICENSE_LINK}
 * @link       ${PROJECT_LINK}
 * @since      Version ${VERSION} 2012-10-31 下午7:16 $
 * @filesource feedback.php
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
 * @link        ${FILE_LINK}/feedback.php
 */
class About extends MT_Controller
{
    public function index()
    {
        $data['seo']['title'] = '关于我们 - 猫头鹰 优美图片休憩之地';
        $this->template('common/header,about/about,common/footer', $data);
    }
    
    public function feedback()
    {
        $data['seo']['title'] = '意见反馈 - 猫头鹰 优美图片休憩之地';
        $this->template('common/header,about/feedback,common/footer', $data);
    }
    
    public function link()
    {
        
    }
}
// END ${CLASS_NAME} class

/* End of file feedback.php */
/* Location: ${FILE_PATH}/feedback.php */