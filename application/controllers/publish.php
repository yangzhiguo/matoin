<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * trunk
 *
 * An open source application development framework for PHP 5.3 or newer
 *
 * @package    ${PACKAGE_NAME}
 * @author     <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2010 - 2012, Yzg, Inc.
 * @license    ${LICENSE_LINK}
 * @link       ${PROJECT_LINK}
 * @since      Version ${VERSION} 2012-09-29 下午4:11 $
 * @filesource publish.php
 */

// ------------------------------------------------------------------------

/**
 * Publish
 *
 * 图片发布控制器
 *
 * @package     ${PACKAGE_NAME}
 * @subpackage  ${SUBPACKAGE_NAME}
 * @category    ${CATEGORY_NAME}
 * @author      <yangzhiguo0903@gmail.com>
 * @link        ${FILE_LINK}/publish.php
 */

class Publish extends MT_Controller
{
    /**
     * 发布引导页
     */
    public function index()
    {
        $this->template('attachment/publish');
    }

    /**
     * 网络发布页
     *
     * @throws Exception
     */
    public function addfromnet()
    {
        try
        {
            if( ! ($this->auth->uid> 0))
            {
                throw new Exception('<script type="text/javascript">redirect(\'\');</script>');
            }
            $this->template('attachment/addfromnet');
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }

    /**
     * 本地发布页
     *
     * @throws Exception
     */
    public function addfromlocal()
    {
        try
        {
            if( ! ($this->auth->uid> 0))
            {
                throw new Exception('<script type="text/javascript">redirect(\'\');</script>');
            }
            $this->load->model('Album_model');
            $data['myalbums'] = $this->Album_model->get_albums($this->auth->uid);

            $sess_cookie = config_item('cookie_prefix') . config_item('sess_cookie_name');
            $session = json_encode(array(
                $sess_cookie => $this->input->cookie($sess_cookie),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            ));

            $this->config->load('upload', TRUE);
            $upload_config = $this->config->item('upload');

            $data['max_size']      = $upload_config['max_size'];
            $data['allowed_types'] = '*.' . str_replace('|', ';*.', $upload_config['allowed_types']);
            $data['post_params']   = $session;

            unset($session, $post_params, $haddler, $value, $sess_cookie, $upload_config);
            $this->template('attachment/addfromlocal', $data);
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }
}

// END Publish class

/* End of file publish.php */
/* Location: ${FILE_PATH}/publish.php */