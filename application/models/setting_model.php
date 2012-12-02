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
 * @version    $Id setting_model.php v1.0.0 2012-02-19 15:34 $
 */

// ------------------------------------------------------------------------

/**
 * 站点设置模型
 *
 * @package     matoin
 * @subpackage  models
 * @category    models
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class Setting_model extends CI_Model
{
    /**
     * @access public
     * @var string 设置表
     */
    public $table_setting = 'common_setting';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 写入或更新设置项
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        $this->db->set(
            array(
                'skey'   => $key,
                'svalue' => $value
            )
        );
        return $this->db->replace($this->table_setting);
    }

    /**
     * 取得已设置项
     *
     * @param $key
     * @return array|bool
     */
    public function get($key)
    {
        $this->db->select('svalue')->from($this->table_setting)->where('skey', $key)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->row()->svalue;
            $query->free_result();
            return $result;
        }
        return FALSE;
    }

}

//END Setting_model Class

/* End of file setting_model.php */
/* Location: ./application/models/setting_model.php */