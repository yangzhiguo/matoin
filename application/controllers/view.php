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
 * @version    $Id view.php v1.0.0 2012-01-24 18:59 $
 */

// ------------------------------------------------------------------------

/**
 * 图片详情
 *
 * @package     matoin
 * @subpackage  Controllers
 * @category    Front-Controllers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class View extends MT_Controller
{
    public function index($imageid)
    {
        if( ! $imageid)
        {
            redirect();
        }
        $imageid = (int)$imageid;
        $this->load->model('Image_model');
        $this->load->model('Album_model');
        $this->load->model('Tag_model');

        $imageinfo = $this->Image_model->get_image($imageid);
        if( ! $imageinfo)
        {
            redirect();
        }
        $imageinfo->username = $this->Member_model->get_member($imageinfo->uid)->username;

        if($imageinfo->albumid> 0)
        {
            $data['albuminfo'] = $this->Album_model->get_album($imageinfo->albumid, FALSE);
            $random_image = $this->Image_model->get_random_image($imageinfo->albumid, $imageid, 6);
            $data['other_image'] = $random_image['list'];
            $data['neighbor'] = $random_image['neighbor'];
        }
        if($this->auth->uid> 0)
        {
            $data['mytag'] = $this->Tag_model->get_my_tag($this->auth->uid, 40);
        }

        $data['taginfo']   = $this->Tag_model->get_item_tag($imageid, 'image', Tag_model::TAG_MAX_NUM);
        $data['imageinfo'] = $imageinfo;
        $data['seo']['title'] = $imageinfo->depict . ' - 猫头鹰 优美图片休憩之地';
        unset($imageinfo, $imageid);
        $this->template('common/header,content/view,common/footer', $data);
    }
}
//END View Class

/* End of file view.php */
/* Location: ./application/controllers/content/view.php */