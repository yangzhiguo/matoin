<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
 * @version    $Id album_model.php v1.0.0 12-5-29 上午9:59 $
 */

// ------------------------------------------------------------------------

/**
 * 专辑模型
 *
 * @package     matoin
 * @subpackage  models
 * @category    models
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class Album_model extends CI_Model
{
    /**
     * 专辑表
     *
     * @access public
     * @var string
     */
    const T_ALBUM = 'album';

    /**
     * 用户表
     *
     * @access public
     * @var string
     */
    const TBN_MEMBER = 'sso_member';

    /**
     * 增加一个专辑
     * 
     * @access public
     * @param $uid
     * @param string $albumname
     * @param string $depict
     * @param int $dateline
     * @param int $updatetime
     * @return bool|void
     */
    public function add($uid, $albumname, $depict = '', $dateline = TIME, $updatetime = TIME)
    {
        if($this->albumname_exists($albumname, $uid))
        {
            return FALSE;
        }
        $this->db->insert(
            self::T_ALBUM,
            array(
                'uid'        => $uid,
                'albumname'  => $albumname,
                'depict'     => $depict,
                'dateline'   => $dateline,
                'updatetime' => $updatetime,
                'coverpic'   => 'static/image/no-cover.png'
            )
        );
        $albumid = $this->db->insert_id();
        if($albumid> 0)
        {
            $this->Member_model->set_member_count($uid, 'albums', 1);
        }
        return $albumid;
    }

    /**
     * 编辑专辑信息
     * 
     * @access public
     * @param int $uid
     * @param int $albumid
     * @param string $albumname
     * @param string $depict
     * @param int $updatetime
     * @return bool|int
     */
    public function edit($uid, $albumid, $albumname, $depict = '', $updatetime = TIME)
    {
        if($this->albumname_exists($albumname, $uid, $albumid))
        {
            return FALSE;
        }
        $data = array(
            'albumname'  => $albumname,
            'depict'     => $depict,
            'updatetime' => $updatetime,
        );
        $this->db->update(self::T_ALBUM, $data, array('albumid' => $albumid, 'uid' => $uid));

        return $this->db->affected_rows();
    }

    /**
     * 更新专辑中图片总数
     * 
     * @access public
     * @param $albumid
     * @param $images
     * @return void|bool
     */
    public function update_total_images($albumid, $images)
    {
        $data = array(
            'updatetime' => TIME
        );
        $this->db
            ->set('`images`', '`images` + ' . $images, FALSE)
            ->update(self::T_ALBUM, $data, array('albumid' => $albumid));
        return $this->db->affected_rows();
    }

    /**
     * 更新专辑封面
     *
     * @access public
     * @param int $albumid
     * @param int $imageid
     * @return bool|int
     */
    public function setcoverpic($albumid, $imageid)
    {
        $this->load->model('Image_model');
        $image = $this->Image_model->get_image($imageid);
        if( ! $image || $image->albumid != $albumid)
        {
            return FALSE;
        }
        $coverpic = $image->attachment;
        $data = array(
            'updatetime' => TIME,
            'coverpic'   => read_attachment($coverpic, '_226_188')
        );
        $this->db->update(self::T_ALBUM, $data, array('albumid' => $albumid));
        return $this->db->affected_rows();
    }

    /**
     * 取得用户的专辑列表
     * 
     * @param $uid
     * @param int $limit
     * @param int $offset
     * @return object|null
     */
    public function get_albums($uid, $limit = 100, $offset = 0)
    {
        $this->db
            ->select('albumid,albumname,dateline,updatetime,images,coverpic')
            ->from(self::T_ALBUM)
            ->where('uid', $uid)
            ->order_by('albumid', 'DESC')
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
     * 取一个专辑的详细信息
     * 
     * @param int $albumid
     * @param bool $is_profile
     * @return null
     */
    public function get_album($albumid = 0, $is_profile = TRUE)
    {
        if($is_profile)
        {
            $this->db
                ->select('albumid,' . self::T_ALBUM . '.uid,albumname,dateline,updatetime,images,coverpic,depict,' . self::TBN_MEMBER . '.username')
                ->from(self::T_ALBUM . ',' . self::TBN_MEMBER)
                ->where('albumid', $albumid)
                ->where(
                $this->db->protect_identifiers(self::T_ALBUM, TRUE) . '.`uid`',
                $this->db->protect_identifiers(self::TBN_MEMBER, TRUE) . '.`uid`',
                FALSE
            )
                ->limit(1);
        }
        else
        {
            $this->db
                ->select('albumid,albumname,images')
                ->from(self::T_ALBUM)
                ->where('albumid', $albumid)
                ->limit(1);
        }
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->row();
            $query->free_result();
            return $result;
        }
        return NULL;
    }

    /**
     * 取得专辑所有者
     * 
     * @access public
     * @param int $albumid
     * @return int|NULL
     */
    public function album_owner($albumid)
    {
        $this->db
            ->select('uid')
            ->from(self::T_ALBUM)
            ->where("`albumid` = '$albumid'")
            ->limit(1);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->row();
            $query->free_result();
            return $result->uid;
        }
        return NULL;
    }

    /**
     * 删除一个专辑
     *
     * @access public
     * @param int $albumid
     * @param int $uid
     * @return mixed
     */
    public function remove_album($albumid = 0, $uid = 0)
    {
        $this->db->delete(self::T_ALBUM, array('albumid' => $albumid, 'uid' => $uid));
        $has_delete = $this->db->affected_rows();
        if($has_delete)
        {
            $this->Member_model->set_member_count($uid, 'albums', -1);
            $this->Image_model->set_image_albuminfo(
                array('albumid' => 0),
                array('albumid' => $albumid, 'uid' => $uid)
            );
        }
        return $has_delete;
    }

    /**
     * 专辑名是否存在
     * 
     * @access public
     * @param $albumname
     * @param $uid
     * @param int $albumid
     * @return bool
     */
    public function albumname_exists($albumname, $uid, $albumid = 0)
    {
        $data = array('uid' => $uid, 'albumname' => $albumname);
        if($albumid> 0)
        {
            $data['albumid !='] = $albumid;
        }
        $this->db
            ->select('albumid')
            ->from(self::T_ALBUM)
            ->where($data)
            ->limit(1);
        $query = $this->db->get();
        $result = $query->num_rows()> 0;
        $query->free_result();
        return $result;
    }
}

//END Album_model Class

/* End of file album_model.php */
/* Location: ./application/models/album_model.php */