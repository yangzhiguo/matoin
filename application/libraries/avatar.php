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
 * @version    $Id avatar.php v1.0.0 2012-01-15 11:13 $
 */

// ------------------------------------------------------------------------

/**
 * 会员头像管理
 *
 * @package     matoin
 * @subpackage  Libraries
 * @category    Front-libraries
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class Avatar
{
    /**
     * 头像尺寸列表
     *
     * @var array
     */
    public $avatar_sizes = array(200 => 'big', 120 => 'middle', 50 => 'small');

    /**
     * 头像类型
     * @var array
     */
    public $image_types = array(
        'jpg', 'png', 'gif', 'jpeg', 'jpe'
    );
    
    /**
     * 默认头像地址
     * 
     * @var string
     */
    public $default_avatar = array();
    
    /**
     * 头像类型
     * 
     * @var string
     */
    public $avatar_ext = 'jpg';

    /**
     * 用户id
     *
     * @var int
     */
    public $uid;

    public function __construct()
    {
        $this->default_avatar = array(
            'big'    => config_item('avatar_default_big'),
            'middle' => config_item('avatar_default_middle'),
            'small'  => config_item('avatar_default_small')
        );
    }
    
    /**
     * 计算头像路径
     * 
     * @return string
     */
    public function avatar_path()
    {
        $uid = sprintf('%09d', $this->uid);
        $dir0 = substr($uid, 0, 3);
        $dir1 = substr($uid, 3, 2);
        $dir2 = substr($uid, 5, 2);
        return sprintf(config_item('avatar_upload_path'), $dir0, $dir1, $dir2);
    }
    
    /**
     * 计算头像源图文件名
     * 
     * @return string
     */
    public function avatar_src()
    {
        return substr(sprintf('%09d', $this->uid), -2) . '_avatar';
    }
    
    /**
     * 头像源完整路径
     *
     * @return bool|string
     */
    public function avatar_src_full_path()
    {
        $full_path = FCPATH . $this->avatar_path() . $this->avatar_src();
        return $full_path . '.' . $this->avatar_ext;
    }


    /**
     * 头像地址
     *
     * @param int $uid
     * @return array
     */
    public function avatar_uri($uid = 0)
    {
        if($uid && $uid> 0)
        {
            $this->uid = (int)$uid;
        }
        $uri = array();
        $realpath = $this->avatar_path() . $this->avatar_src();
        $realpath = str_replace('\\', '/', $realpath);

        foreach ($this->avatar_sizes as $size)
        {
            $uri[$size] = is_file(FCPATH . $realpath . '_' . $size . '.' . $this->avatar_ext) ?
                          $realpath . '_' . $size . '.' . $this->avatar_ext :
                          $this->default_avatar[$size];
        }
        return $uri;
    }
    
}
//END Avatar Class

/* End of file avatar.php */
/* Location: ./application/libraries/avatar.php */