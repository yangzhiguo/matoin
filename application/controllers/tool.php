<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * matoin System
 *
 * 猫头鹰matoin - 寻找最有价值的东西
 *
 * matoin - to help you find the most valuable thing
 *
 * @package    matoin
 * @author     yzg <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2011 - 2012, matoin.com.
 * @license    GNU General Public License 2.0
 * @link       http://www.matoin.com/
 * @version    $Id tool.php v1.0.0 2012-01-24 18:59 $
 */

// ------------------------------------------------------------------------

/**
 * 收藏工具
 *
 * @package     matoin
 * @subpackage  Controllers
 * @category    Front-Controllers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class Tool extends MT_Controller
{

    public function index()
    {
        $this->template('common/header,tool/index,common/footer');
    }

    /**
     *  收集工具落脚点
     */
    public function to()
    {
        $split = array('-', '_', '—', '|');

        $this->load->model('Album_model');

        $src   = $this->input->get('i');
        $title = $this->input->get('t');
        $link  = $this->input->get('u');
        if( ! $src)
        {
            redirect();
        }
        foreach($split as $separator)
        {
            if(FALSE !== strpos($title, $separator))
            {
                $split_title = array_filter(explode($separator, $title));
                foreach($split_title as $piece)
                {
                    if($piece = trim($piece))
                    {
                        $title = $piece;
                        break;
                    }
                }
                break;
            }
        }
        $data = array(
            'src'   => $src,
            'title' => $title,
            'link'  => $link
        );

        $data['myalbums'] = $this->Album_model->get_albums($this->auth->uid);

        $this->template('common/header,tool/toolaccess,common/footer', $data);
    }

    /**
     * 升级浏览器
     */
    public function update_your_browser()
    {
        $this->template('common/header,tool/update_your_brower,common/thinfooter');
    }
}
//END Tool Class

/* End of file tool.php */
/* Location: ./application/controllers/content/tool.php */