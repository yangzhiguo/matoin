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
 * @since      Version ${VERSION} 2012-08-05 上午2:11 $
 * @filesource image_model.php
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
 * @link        ${FILE_LINK}/image_model.php
 */

class Image_model extends CI_Model
{
    /**
     * 图片表
     *
     * @access public
     * @var string
     */
    const T_IMAGE = 'image';

    /**
     * 图片表-统计字段
     *
     * @var array
     */
    public $image_count_fields = array(
        'tag'     => 'tagnum',
        'comment' => 'commenttimes',
        'fave'    => 'favetimes'
    );

    /**
     * 图片关系表
     *
     * @access public
     * @var string
     */
    const T_IMAGEITEM = 'imageitem';

    const T_MEMBER    = 'sso_member';

    /**
     * 收藏一张图片
     *
     * @param int $imageid
     * @param int $uid
     * @return bool
     */
    public function fave_image($imageid = 0, $uid = 0)
    {
        $this->db->insert(self::T_IMAGEITEM, array('imageid' => $imageid, 'uid' => $uid, 'dateline' => TIME));
        $affected1 = $this->db->affected_rows();
        $affected2 = $this->Member_model->set_member_count($uid, 'images', 1);
        $affected3 = $this->set_count($imageid, 'fave', 1);
        return $affected1 && $affected2 && $affected3;
    }

    /**
     * 取消收藏一张图片
     *
     * @param int $imageid
     * @param int $uid
     * @return bool
     */
    public function unfave_image($imageid = 0, $uid = 0)
    {
        $this->db->delete(self::T_IMAGEITEM, array('imageid' => $imageid, 'uid' => $uid));
        $affected1 = $this->db->affected_rows();
        $affected2 = $this->Member_model->set_member_count($uid, 'images', -1);
        $affected3 = $this->set_count($imageid, 'fave', -1);
        return $affected1 && $affected2 && $affected3;
    }

    /**
     * 查询用户收藏的图片
     *
     * @param int $uid
     * @param int $limit
     * @param int $offset
     * @return array|null
     */
    public function get_user_fave_image($uid, $limit = 10, $offset = 0)
    {
        $this->db
            ->select(self::T_IMAGE . '.imageid,' . self::T_IMAGE . '.uid,depict,attachment,' . self::T_IMAGE . '.dateline,username')
            ->from(self::T_IMAGEITEM . ',' . self::T_IMAGE . ',' . self::T_MEMBER)
            ->where(self::T_IMAGEITEM . '.uid', $uid)
            ->where(
            $this->db->protect_identifiers(self::T_IMAGEITEM, TRUE) . '.`imageid`',
            $this->db->protect_identifiers(self::T_IMAGE, TRUE) . '.`imageid`',
            FALSE
        )
            ->where(
            $this->db->protect_identifiers(self::T_MEMBER, TRUE) . '.`uid`',
            $this->db->protect_identifiers(self::T_IMAGE, TRUE) . '.`uid`',
            FALSE
        )
            ->order_by(self::T_IMAGEITEM . '.dateline', 'DESC')
            ->limit($limit, $offset);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->result();
            $query->free_result();
            return $this->with_fave_info($result);
        }
        return NULL;
    }

    /**
     * 收藏信息
     *
     * @param array $result
     * @return array
     */
    public function with_fave_info($result = array())
    {
        $imagelist = $imageid_queue = array();
        foreach($result as $item)
        {
            $imageid_queue[] = $item->imageid;
            $imagelist[$item->imageid] = $item;
        }
        $faveinfo = $this->fava_or_not($imageid_queue);
        foreach($imagelist as $key => & $value)
        {
            $value->fave = isset($faveinfo[$key]) ? 1 : 0;
        }
        return $imagelist;
    }

    /**
     * 是否收藏
     *
     * @param array $imageid_queue
     * @return array
     */
    public function fava_or_not($imageid_queue = array())
    {
        $result = array();
        $logined_uid = $this->auth->uid;
        if($this->auth->uid> 0)
        {
            $this->db
                ->select('imageid')
                ->from(self::T_IMAGEITEM)
                ->where('uid', $logined_uid)
                ->where_in('imageid', $imageid_queue);
            $fave_query = $this->db->get();
            if($fave_query->num_rows()> 0)
            {
                $fave_queue = $fave_query->result();
                $fave_query->free_result();
                foreach($fave_queue as $queue)
                {
                    $result[$queue->imageid] = 1;
                }
                unset($imageid_queue, $fave_queue, $fave_query, $queue);
            }
        }
        return $result;
    }

    /**
     * 增加一张图片
     *
     * @param int $albumid
     * @param int $uid
     * @param string $postip
     * @param string $depict
     * @param int $size
     * @param string $attachment
     * @param int $dateline
     * @param int $collection 收集方式{1:浏览器工具,2:自己上传,3:从互联网上传}
     * @param string $origin 来源
     * @return int mixed
     */
    public function add($albumid, $uid, $postip, $depict, $size, $attachment, $dateline = TIME, $collection = 1, $origin = '')
    {
        $this->db->insert(
            self::T_IMAGE,
            array(
                'albumid'    => $albumid,
                'uid'        => $uid,
                'postip'     => $postip,
                'depict'     => $depict,
                'size'       => $size,
                'attachment' => $attachment,
                'dateline'   => $dateline,
                'collection' => $collection,
                'origin'     => $origin
            )
        );
        $imageid = $this->db->insert_id();
        if($imageid> 0)
        {
            $this->fave_image($imageid, $uid);
        }
        return $imageid;
    }

    /**
     * 查询专辑内图片
     *
     * @param int $albumid
     * @param int $limit
     * @param int $offset
     * @return array|null
     */
    public function get_album_image($albumid, $limit = 10, $offset = 0)
    {
        $this->db
            ->select('imageid,albumid,uid,dateline,attachment,depict')
            ->from(self::T_IMAGE)
            ->where('albumid', $albumid)
            ->order_by('imageid', 'DESC')
            ->limit($limit, $offset);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->result();
            $query->free_result();
            return $this->with_fave_info($result);
        }
        return NULL;
    }

    /**
     * 查询最新图片
     *
     * @param array $option
     * @return array|null
     */
    public function get_custom_image($option = array(), $cus_condition = array())
    {
        $option += array(
            'limit'  => 10,
            'offset' => 0,
            'page_switch' => TRUE,
            'order' => 'imageid',
            'sort'  => 'DESC'
        );
        $condition = array(
            'albumid !=' => 0,
            'status' => 0
        );
        if(!empty($cus_condition))
        {
            $condition = array_merge($condition, $cus_condition);
        }
        $this->db
            ->select('imageid,albumid,' . self::T_MEMBER . '.uid,' . self::T_MEMBER . '.username,dateline,attachment,depict')
            ->from(self::T_IMAGE . ',' . self::T_MEMBER)
            ->where($this->db->protect_identifiers(self::T_MEMBER . '.uid'), $this->db->protect_identifiers(self::T_IMAGE . '.uid'), FALSE)
            ->where($condition);

        if(isset($option['imageids']) && is_array($option['imageids']))
        {
            $this->db->where_in('imageid', $option['imageids']);
        }
        $this->db->order_by($option['order'], $option['sort']);
        if($option['page_switch'] === TRUE)
        {
            $this->db->limit($option['limit'], $option['offset']);
        }
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->result();
            $query->free_result();
            return $this->with_fave_info($result);
        }
        return NULL;
    }

    /**
     * 查询一张图片
     *
     * @param int $imageid
     * @return null|mixed
     */
    function get_image($imageid)
    {
        $result = NULL;
        $this->db
            ->select('imageid,albumid,uid,dateline,attachment,depict,favetimes,commenttimes,collection,origin')
            ->from(self::T_IMAGE)
            ->where('imageid', $imageid)
            ->limit(1);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->row();
            $query->free_result();
        }
        if( ! empty($result))
        {
            $faveinfo = $this->fava_or_not(array($result->imageid));
            $whofave = $this->_who_fave($imageid);
            $result->fave = isset($faveinfo[$result->imageid]) && $faveinfo[$result->imageid] ? 1 : 0;
            $result->whofave = $whofave;
        }
        return $result;
    }

    /**
     * 随机取专辑内$limit张图片
     *
     * @param int $albumid
     * @param int $imageid
     * @param int $limit
     * @return object|null
     */
    public function get_random_image($albumid = 0, $imageid = 0, $limit = 0)
    {
        $result  = $gt_result = $lt_result = array();
        $albumid = (int)$albumid;
        $limit   = (int)$limit;
        $imageid = (int)$imageid;
        $avg     = intval($limit / 2);

        if( ! $albumid || ! $limit || ! $imageid)
        {
            return NULL;
        }
        $this->db
            ->select('imageid,attachment,depict')
            ->from(self::T_IMAGE)
            ->where(array('albumid' => $albumid, 'imageid >=' => $imageid))
            ->order_by('imageid', 'ASC')
            ->limit($limit);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $gt_result = $query->result();
            $query->free_result();
        }

        $this->db
            ->select('imageid,attachment,depict')
            ->from(self::T_IMAGE)
            ->where(array('albumid' => $albumid, 'imageid <' => $imageid))
            ->order_by('imageid', 'DESC')
            ->limit($limit);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $lt_result = $query->result();
            $query->free_result();
        }

        $lt_avg = $gt_avg = 0;
        $gt_len = count($gt_result);
        $lt_len = count($lt_result);
        if($gt_len>= $avg && $lt_len>= $avg)
        {
            $lt_avg = $gt_avg = $avg;
        }
        else if($gt_len <$avg)
        {
            $gt_avg = $gt_len;
            $lt_avg = $limit - $gt_len;
        }
        else if($lt_len <$avg)
        {
            $gt_avg = $limit - $lt_len;
            $lt_avg = $lt_len;
        }
        $result['list'] = array_merge(
            array_reverse(
                array_slice($gt_result, 0, $gt_avg)
            ),
            array_slice($lt_result, 0, $lt_avg)
        );
        $nabor = array();
        if( ! empty($result['list']))
        {
            foreach($result['list'] as $v)
            {
                $nabor[] = $v->imageid;
            }
        }
        $result['neighbor'] = $nabor;
        unset($albumid, $imageid, $limit, $avg, $gt_avg, $result_len, $remind, $query, $lt_result, $lt_len, $lt_avg, $gt_result, $gt_len, $gt_avg);
        return $result;
    }

    /**
     * 设置图片的专辑信息
     *
     * @param array $data
     * @param array $where
     * @return mixed
     */
    public function set_image_albuminfo($data = array(), $where = array())
    {
        $this->db->update(self::T_IMAGE, $data, $where);
        return $this->db->affected_rows();
    }

    /**
     * 检查图片是否存在
     *
     * @param int $imageid
     * @param int $uid
     * @return bool
     */
    public function image_exists($imageid = 0, $uid = NULL)
    {
        $condition = $uid === NULL ? array('imageid' => $imageid) : array('uid' => $uid, 'imageid' => $imageid);
        $this->db
            ->select('imageid')
            ->from(self::T_IMAGE)
            ->where($condition)
            ->limit(1);
        $query = $this->db->get();
        $result = $query->num_rows()> 0;
        $query->free_result();
        return $result;
    }

    /**
     * 读取收藏图片的人
     *
     * @param int $imageid
     * @return null|array
     */
    public function _who_fave($imageid = 0)
    {
        $result = NULL;
        $this->db
            ->select(self::T_MEMBER . '.uid,' . self::T_MEMBER . '.username')
            ->from(self::T_IMAGEITEM . ',' . self::T_MEMBER)
            ->where('imageid', $imageid)
            ->where(
            $this->db->protect_identifiers(self::T_MEMBER, TRUE) . '.`uid`',
            $this->db->protect_identifiers(self::T_IMAGEITEM, TRUE) . '.`uid`',
            FALSE
        )
            ->order_by('dateline', 'DESC')
            ->limit(40);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->result();
            $query->free_result();
        }
        return $result;
    }

    /**
     * 设置图片统计项
     *
     * @param int $imageid
     * @param string $field
     * @param int $step
     * @return bool|int
     */
    public function set_count($imageid = 0, $field = '', $step = 1)
    {
        $result = FALSE;
        if( ! isset($this->image_count_fields[$field]))
        {
            return $result;
        }
        $column = $this->image_count_fields[$field];
        $this->db
            ->set("`$column`", "`$column` + " . (int)$step, FALSE)
            ->update(self::T_IMAGE, array(), array('imageid' => $imageid));
        $result = $this->db->affected_rows();
        return $result;
    }

    /**
     * 查询图片统计项
     *
     * @param int $imageid
     * @param string $field
     * @return null|int
     */
    public function get_count($imageid = 0, $field = '')
    {
        $result = NULL;
        if( ! isset($this->image_count_fields[$field]))
        {
            return $result;
        }
        $column = $this->image_count_fields[$field];
        $this->db
            ->select($column)
            ->from(self::T_IMAGE)
            ->where('imageid', $imageid)
            ->limit(1);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->row();
            if(isset($result->$column))
            {
                $result = (int)$result->$column;
            }
            $query->free_result();
        }
        return $result;
    }
}
// END ${CLASS_NAME} class

/* End of file image_model.php */
/* Location: ${FILE_PATH}/image_model.php */
