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
 * @since      Version ${VERSION} 2012-08-17 上午11:00 $
 * @filesource comment_model.php
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
 * @link        ${FILE_LINK}/comment_model.php
 */

class Comment_model extends CI_Model
{
    /**
     * 评论表
     *
     * @access public
     * @var string
     */
    const T_COMMENT = 'comment';

    /**
     * 评论内容
     *
     * @access public
     * @var string
     */
    public $message = '';

    /**
     * 添加一条评论|回复
     *
     * @param int $cid
     * @param int $uid
     * @param int $itemid
     * @param string $idtype
     * @param int $authorid
     * @param string $author
     * @param string $message
     * @param string $ip
     * @param int $dateline
     * @param int $status
     * @return mixed|int
     */
    public function add_comment($cid, $uid, $itemid, $idtype, $authorid, $author, $message, $ip = '', $dateline = TIME, $status = 0)
    {
        if($cid> 0)
        {
            $this->db
                ->select('author,message')
                ->from(self::T_COMMENT)
                ->where(array('cid' => $cid, 'itemid' => $itemid, 'idtype' => $idtype))
                ->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() && preg_match('/^回复.*?\:.*?/i', $message))
            {
                $result = $query->row();
                $query->free_result();

                $quotemessage = preg_replace("/\<div class=\"quote\"\>\<blockquote\>.*?\<\/blockquote\>\<\/div\>/is", '', $result->message);
                $quotemessage = mb_strlen($quotemessage)> 30 ? mb_substr($quotemessage, 0, 30) . '...' : $quotemessage;
                $quote = '<div class="quote"><blockquote>' . $result->author . ':&nbsp;' . $quotemessage . '</blockquote></div>';
                unset($quotemessage);

                $message = trim(preg_replace('/回复.*?\:/is', '', $message));
                if( ! $message)
                {
                    return -1;
                }
                $message = $quote . $message;
            }
        }
        $this->message = $message;

        $this->db->insert(
            self::T_COMMENT,
            array(
                'uid'      => $uid,
                'itemid'   => $itemid,
                'idtype'   => $idtype,
                'authorid' => $authorid,
                'author'   => $author,
                'ip'       => $ip ? $ip : $this->input->ip_address(),
                'message'  => $message,
                'dateline' => $dateline ? $dateline : TIME,
                'status'   => $status
            )
        );
        $insertid = $this->db->insert_id();
        $this->load->model('Image_model');
        $this->Image_model->set_count($itemid, 'comment', 1);
        return $insertid;
    }

    /**
     * 取评论|回复
     *
     * @param int $itemid
     * @param string $idtype
     * @param int $limit
     * @param int $offset
     * @return null|object
     */
    public function get_comment($itemid, $idtype, $limit = 10, $offset = 0)
    {
        $this->db
            ->select('cid,uid,authorid,author,dateline,message')
            ->from(self::T_COMMENT)
            ->where(array('itemid' => $itemid, 'idtype' => $idtype))
            ->order_by('cid', 'ASC')
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
     * 删除一条评论|回复
     *
     * @param int $cid
     * @param int $authorid
     * @return int
     */
    public function delete_comment($cid = 0, $authorid = 0)
    {
        $this->db
            ->select('itemid')
            ->from(self::T_COMMENT)
            ->where(array('cid' => $cid, 'authorid' => $authorid))
            ->limit(1);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            $result = $query->row();
            $query->free_result();
            $this->load->model('Image_model');
            $this->Image_model->set_count($result->itemid, 'comment', -1);
        }
        $this->db->delete(self::T_COMMENT, array('cid' => $cid, 'authorid' => $authorid));
        return $this->db->affected_rows();
    }

    /**
     * 评论|回复分页
     *
     * @param int $itemid
     * @param string $idtype
     * @param int $pagesize
     * @param int $offset
     * @param int $total
     * @param string $anchor_class
     * @param string $base_url
     * @return array
     */
    public function comment_pagination($itemid, $idtype, $pagesize, $offset, $total, $anchor_class, $base_url)
    {
        $this->load->library('pagination');

        $config['base_url']     = $base_url;
        $config['total_rows']   = (int)$total;
        $config['per_page']     = $pagesize;
        $config['anchor_class'] = $anchor_class;  //FIXME 这里利用了pagination类的一个bug,codeigniter升级时候应该注意此处.

        $this->pagination->initialize($config);

        $data['page']       = $this->pagination->create_links();
        $data['commentinfo']= $this->get_comment($itemid, $idtype, $pagesize, ($offset - 1) * $pagesize);
        return $data;
    }
}

// END ${CLASS_NAME} class

/* End of file comment_model.php */
/* Location: ${FILE_PATH}/comment_model.php */