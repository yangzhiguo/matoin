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
 * @since      Version ${VERSION} 2012-08-13 下午5:27 $
 * @filesource tag_model.php
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
 * @link        ${FILE_LINK}/tag_model.php
 */

class Tag_model extends CI_Model
{
    /**
     * 项目可打的图片上限
     */
    const TAG_MAX_NUM = 40;
    
    /**
     * 标签表
     *
     * @access public
     * @var string
     */
    const T_TAG = 'tag';

    /**
     * 标签关系表
     *
     * @access public
     * @var string
     */
    const T_TAGITEM = 'tagitem';

    /**
     * 增加一个标签实体
     *
     * @access public
     * @param string $tagname
     * @param int $uid
     * @param int $dateline
     * @return int
     */
    public function add($tagname = '', $uid = 0, $dateline = TIME)
    {
        $this->db
            ->select('tagid')
            ->from(self::T_TAG)
            ->where(array('tagname' => $tagname))
            ->limit(1);
        $query = $this->db->get();
        if ($query->num_rows()> 0)
        {
            $result = $query->row();
            $query->free_result();
            return $result->tagid;
        }

        $this->db->insert(
            self::T_TAG,
            array(
                'uid'      => $uid,
                'tagname'  => $tagname,
                'dateline'   => $dateline,
                'updatetime' => $dateline
            )
        );
        return $this->db->insert_id();
    }

    /**
     * 我的标签库[最近使用]
     *
     * @param int $uid
     * @param int $limit
     * @return null|object
     */
    public function get_my_tag($uid = 0, $limit = 6)
    {
        $this->db
            ->select('tagname')
            ->from(self::T_TAG)
            ->where(array('uid' => $uid))
            ->order_by('updatetime', 'DESC')
            ->limit($limit);
        $query = $this->db->get();
        if($query->num_rows()> 0)
        {
            $result = $query->result();
            $query->free_result();
            return $result;
        }
        return NULL;
    }

    /**
     * 设置标签
     *
     * @param $tagname
     * @param $uid
     * @param $itemid
     * @param $idtype
     * @return bool|int
     */
    public function set_tag($tagname, $uid, $itemid, $idtype)
    {
        $this->load->model('Image_model');
        $tagnum = $this->Image_model->get_count($itemid, 'tag');
        if($tagnum>= self::TAG_MAX_NUM)
        {
            return FALSE;
        }
        $tagid = $this->add($tagname, $uid);
        $this->db
            ->select('tagid')
            ->from(self::T_TAGITEM)
            ->where(array('idtype' => $idtype, 'itemid' => $itemid, 'tagname' => $tagname))
            ->limit(1);
        $query = $this->db->get();
        if ($query->num_rows()> 0)
        {
            return FALSE;
        }
        $this->db->set("`images`", "`images` + 1", FALSE)->update(self::T_TAG, array('updatetime' => TIME), array('tagid' => $tagid));
        $this->db->insert(
            self::T_TAGITEM,
            array('tagid' => $tagid, 'tagname' => $tagname, 'uid' => $uid, 'itemid' => $itemid, 'idtype' => $idtype)
        );
        $this->Image_model->set_count($itemid, 'tag', 1);
        return $tagid;
    }

    /**
     * 取得已打的标签
     *
     * @param $itemid
     * @param $idtype
     * @param int $limit
     * @return null|object
     */
    public function get_item_tag($itemid, $idtype, $limit = 0)
    {
        $this->db
            ->select('tagid,uid,tagname')
            ->from(self::T_TAGITEM)
            ->where(array('idtype' => $idtype, 'itemid' => $itemid))
            ->limit($limit);
        $query = $this->db->get();
        if ($query->num_rows()> 0)
        {
            $result = $query->result();
            $query->free_result();
            return $result;
        }
        return NULL;
    }

    /**
     * 删除已打标签
     * 
     * @param int $tagid
     * @param int $itemid
     * @param string $idtype
     * @param null $uid
     * @return mixed
     */
    public function delete_item_tag($tagid = 0, $itemid = 0, $idtype = 'image',  $uid = NULL)
    {
        $condition = array(
            'tagid'  => $tagid, 
            'idtype' => $idtype, 
            'itemid' => $itemid
        );
        if($uid !== NULL)
        {
            $condition['uid'] = $uid;
        }
        $this->db->delete(self::T_TAGITEM, $condition);
        $this->db->set("`images`", "`images` - 1", FALSE)->update(self::T_TAG, array('updatetime' => TIME), array('tagid' => $tagid));
        $this->Image_model->set_count($itemid, 'tag', -1);
        return $this->db->affected_rows();
    }

    /**
     * 读取所有标签
     * 
     * @param int $limit
     * @param int $offset
     * @return null
     */
    public function get_all_tag($limit = 150, $offset = 0)
    {
        $this->db
            ->select('tagid,tagname')
            ->from(self::T_TAG)
            ->order_by('images', 'DESC')
            ->limit($limit, $offset);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->result();
            $query->free_result();
            return $result;
        }
        return NULL;
    }

    /**
     * 查询标签总数
     * 
     * @return int
     */
    public function total_rows()
    {
         return $this->db->count_all_results(self::T_TAG);
    }

    /**
     * 读取标签对应图片
     * 
     * @param int $tagid
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_tag_profile($tagid = 0, $limit = 10, $offset = 0)
    {
        $taginfo = $images = array();
        $this->db->select('tagname,images')->from(self::T_TAG)->where('tagid', $tagid)->limit(1);
        $query = $this->db->get();
        if($query->num_rows())
        {
            $taginfo = $query->row_array();
            $query->free_result();
        }
        $this->db
            ->select('itemid')
            ->from(self::T_TAGITEM)
            ->where(array('tagid' => $tagid, 'idtype' => 'image'))
            ->limit($limit, $offset);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $imageids = array();
            $result = $query->result_array();
            $query->free_result();
            foreach($result as $image)
            {
                $imageids[] = $image['itemid'];
            }
            unset($result, $image);
            $cdt = array(
                'page_switch' => FALSE,
                'imageids'    => $imageids
            );
            $this->load->model('Image_model');
            $taginfo['imageinfo'] = $this->Image_model->get_custom_image($cdt);
        }
        return $taginfo;
    }
}

// END ${CLASS_NAME} class

/* End of file tag_model.php */
/* Location: ${FILE_PATH}/tag_model.php */