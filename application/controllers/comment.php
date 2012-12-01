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
 * @since      Version ${VERSION} 2012-08-18 上午1:41 $
 * @filesource comment.php
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
 * @link        ${FILE_LINK}/comment.php
 */

class Comment extends MT_Controller
{
    /**
     * 评论模型
     *
     * @access public
     * @var object
     */
    public $Comment_model;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Comment_model');
        $this->load->model('Image_model');
        $this->load->library('form_validation');
    }

    /**
     * 增加一条评论|回复
     *
     * @throws Exception
     */
    public function add()
    {
        try
        {
            if ( ! ($this->auth->uid> 0))
            {
                throw new Exception('<p>请先登录</p>');
            }
            $this->form_validation->set_rules('imageid', '图片id', 'trim|required|is_natural');
            $this->form_validation->set_rules('uid', '用户id', 'trim|required|is_natural');
            $this->form_validation->set_rules('addcomment', '评论内容', 'trim|required|min_length[1]|max_length[140]');
            if ($this->form_validation->run() === FALSE)
            {
                throw new Exception($this->form_validation->error_string());
            }
            else
            {
                $cid     = (int)$this->input->post('cid');
                $uid     = (int)$this->input->post('uid');
                $imageid = (int)$this->input->post('imageid');
                $message = dhtmlspecialchars($this->input->post('addcomment'));
                $idtype  = 'image';

                if( ! $this->Image_model->image_exists($imageid, $uid))
                {
                    throw new Exception('<p>该图片不存在</p>');
                }

                $cid = $this->Comment_model->add_comment(
                    $cid,
                    $uid,
                    $imageid,
                    $idtype,
                    $this->auth->uid,
                    $this->auth->userinfo->username,
                    $message
                );
                if($cid> 0)
                {
                    $result = array(
                        'cid' => $cid,
                        'authorid' => $this->auth->uid,
                        'author'   => $this->auth->userinfo->username,
                        'avatar'   => avatar_uri($this->auth->uid, 'small'),
                        'message'  => $this->Comment_model->message,
                        'dateline' => time_ago(TIME),
                    );

                    $this->output->set_output(
                        json_encode($result)
                    );
                }
                else if($cid == -1)
                {
                    throw new Exception('<p>总要写点什么吧</p>');
                }
                else
                {
                    throw new Exception('<p>评论失败</p>');
                }
            }
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }

    /**
     * 删除一条评论|回复
     *
     * @param $cid
     * @throws Exception
     */
    public function delete($cid)
    {
        try
        {
            if ( ! ($this->auth->uid> 0))
            {
                throw new Exception('<p>请先登录</p>');
            }
            $cid = (int)$cid;
            $stat = $this->Comment_model->delete_comment($cid, $this->auth->uid);
            if($stat> 0)
            {
                $this->output->set_output($stat);
            }
            else
            {
                throw new Exception('<p>评论不存在</p>');
            }
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }

    /**
     * 评论|回复翻页列表
     *
     * @throws Exception
     */
    public function pagination()
    {
        try
        {
            $pagesize = 4;
            $itemid = abs((int)$this->input->get('itemid'));
            $page   = (int)$this->input->get('p');
            if($page< 1)
            {
                $page = 1;
            }
            $imageinfo = $this->Image_model->get_image($itemid);
            if( ! $imageinfo)
            {
                throw new Exception('<p>图片不存在</p>');
            }

            if($page> $total = ceil($imageinfo->commenttimes / $pagesize))
            {
                $page = $total;
                unset($total);
            }
            $pagination = $this->Comment_model->comment_pagination(
                $itemid,
                'image',
                $pagesize,
                $page,
                $imageinfo->commenttimes,
                'onclick="return cmtpage(this);" ',
                base_url('view/' . $itemid)
            );
            if( ! $pagination['commentinfo'])
            {
                throw new Exception('<p>暂无评论</p>');
            }
            foreach($pagination['commentinfo'] as & $value)
            {
                $value->avatar = avatar_uri($value->authorid, 'small');
                $value->dateline = time_ago($value->dateline);
                $value->ismine   = $value->authorid == $this->auth->uid && $this->auth->uid> 0;
                $value->haslogin = $this->auth->uid> 0;
            }
            $this->output->set_output(
                json_encode(array(
                    'page' => $pagination['page'],
                    'cmt'  => $pagination['commentinfo'],
                ))
            );
        }
        catch(Exception $e)
        {
            $this->output->set_output($e->getMessage());
        }
    }
}

// END Comment class

/* End of file comment.php */
/* Location: ${FILE_PATH}/comment.php */