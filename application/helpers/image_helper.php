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
 * @since      Version ${VERSION} 2012-08-05 下午4:43 $
 * @filesource image_helper.php
 */

// ------------------------------------------------------------------------

/**
 * 图像缩略，无拉伸填充裁剪
 *
 * @param $source_image
 * @param $src_width
 * @param $src_height
 * @param $dst_width
 * @param $dst_height
 * @return bool
 */
if( ! function_exists('soft_resize_cut'))
{
    function soft_resize_cut($source_image, $src_width, $src_height, $dst_width, $dst_height)
    {
        $CI = & get_instance();
        $CI->load->library('image_lib');

        $propor = min(max($dst_width / $src_width, $dst_height / $src_height), 1);
        $dst_w  = (int)round($src_width * $propor);
        $dst_h  = (int)round($src_height * $propor);
        $x      = ($dst_width - $dst_w) / 2;
        $y      = ($dst_height - $dst_h) / 2;

        $config['quality']          = 100;
        $config['source_image']     = $source_image;
        $config['create_thumb']     = TRUE;
        $config['master_dim']       = 'auto';
        $config['x_dst']            = $x;
        $config['y_dst']            = $y;
        $config['x_axis']           = 0;
        $config['y_axis']           = 0;
        $config['orig_width']       = $src_width;
        $config['orig_height']      = $src_height;
        $config['maintain_ratio']   = TRUE;
        $config['width']            = $dst_w;
        $config['height']           = $dst_h;
        $config['dst_creat_width']  = $dst_width;
        $config['dst_creat_height'] = $dst_height;
        $config['thumb_marker']     = '_' . $dst_width . '_' . $dst_height;

        $CI->image_lib->initialize($config);
        $CI->image_lib->thumb_crop($config);
        $full_dst_path =  $CI->image_lib->full_dst_path;
        $CI->image_lib->clear();
        return $full_dst_path;
    }
}

/**
 * 缩放到指定宽度
 *
 * @param string $source_image
 * @param int $src_width
 * @param int $src_height
 * @param int $dst_width
 * @return bool
 */
if( ! function_exists('resize_to_width'))
{
    function resize_to_width($source_image, $src_width, $src_height, $dst_width)
    {
        $CI = & get_instance();
        $CI->load->library('image_lib');

        $dst_height = intval(($dst_width / $src_width) * $src_height);

        $config['quality']          = 100;
        $config['source_image']     = $source_image;
        $config['create_thumb']     = TRUE;
        $config['width']            = $dst_width;
        $config['height']           = $dst_height;
        $config['thumb_marker']     = '_' . $dst_width;
        $config['x_axis']           = 0;
        $config['y_axis']           = 0;

        $CI->image_lib->initialize($config);
        $CI->image_lib->resize($config);
        $CI->image_lib->clear();
        return TRUE;
    }
}

/**
 * 按规格读取图片地址
 *
 * @param string $source_image
 * @param string $thumb_maker
 * @return string
 */
if( ! function_exists('read_attachment'))
{
    function read_attachment($source_image = '', $thumb_maker = '')
    {
        $ext = strrchr($source_image, '.');
        $name = ($ext === FALSE) ? $source_image : substr($source_image, 0, -strlen($ext));
        return $name . $thumb_maker . $ext;
    }
}
/* End of file image_helper.php */
/* Location: ${FILE_PATH}/image_helper.php */
