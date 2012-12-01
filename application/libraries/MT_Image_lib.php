<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: yzg
 * Date: 12-6-26
 * Time: 下午4:15
 * To change this template use File | Settings | File Templates.
 */
class MT_Image_lib extends CI_Image_lib
{
    /**
     * Image Resize and Crop
     *
     * 缩放并裁剪，仅在GD2下工作
     *
     * @access	public
     * @param   array $config
     * @return	bool
     */
    public function resize_crop($config = array())
    {
        $protocol = 'image_process_'.$this->image_library;
        if (preg_match('/gd2$/i', $protocol))
        {
            $protocol = 'mt_image_process_gd';
        }
        foreach ($config as $key => $val)
        {
            $this->$key = $val;
        }
        return $this->$protocol('resize_crop');
    }

    // --------------------------------------------------------------------

    /**
     * Image Thumb and Crop
     *
     * 缩放后裁剪，仅在GD2下工作
     *
     * @access public
     * @param array $config
     * @return bool
     */
    public function thumb_crop($config = array())
    {
        $protocol = 'image_process_'.$this->image_library;
        if (preg_match('/gd2$/i', $protocol))
        {
            $protocol = 'mt_image_process_gd';
        }
        foreach ($config as $key => $val)
        {
            $this->$key = $val;
        }
        return $this->$protocol('thumb_crop');
    }

    // --------------------------------------------------------------------

    /**
     * Image Process Using GD/GD2
     *
     * This function will resize or crop
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public function mt_image_process_gd($action = 'resize')
    {
        $v2_override = FALSE;
        $x = $y = 0;

        //如果目标的宽度/高度匹配的来源，如果新的文件名不等于旧文件名
        //我们将简单地使原来用新的名称的副本...假设动态渲染是关闭的。
        if ($this->dynamic_output === FALSE && $action !== 'resize_crop')
        {
            if ($this->orig_width == $this->width AND $this->orig_height == $this->height)
            {
                if ($this->source_image != $this->new_image)
                {
                    if (@copy($this->full_src_path, $this->full_dst_path))
                    {
                        @chmod($this->full_dst_path, FILE_WRITE_MODE);
                    }
                }

                return TRUE;
            }
        }

        // Let's set up our values based on the action
        if ($action == 'crop')
        {
            //  Reassign the source width/height if cropping
            $this->orig_width  = $this->width;
            $this->orig_height = $this->height;

            // GD 2.0 has a cropping bug so we'll test for it
            if ($this->gd_version() !== FALSE)
            {
                $gd_version = str_replace('0', '', $this->gd_version());
                $v2_override = ($gd_version == 2) ? TRUE : FALSE;
            }
        }
        else if ($action == 'resize_crop')
        {
            //do nothing
        }
        else if ($action == 'thumb_crop')
        {
            //If resizing the x/y axis not must be zero
            $x = $this->x_dst;
            $y = $this->y_dst;
        }
        else
        {
            // If resizing the x/y axis must be zero
            $this->x_axis = 0;
            $this->y_axis = 0;
        }

        //  Create the image handle
        if ( ! ($src_img = $this->image_create_gd()))
        {
            return FALSE;
        }

        //  Create The Image
        //
        //  old conditional which users report cause problems with shared GD libs who report themselves as "2.0 or greater"
        //  it appears that this is no longer the issue that it was in 2004, so we've removed it, retaining it in the comment
        //  below should that ever prove inaccurate.
        //
        //  if ($this->image_library == 'gd2' AND function_exists('imagecreatetruecolor') AND $v2_override == FALSE)
        if ($this->image_library == 'gd2' AND function_exists('imagecreatetruecolor'))
        {
            $create	= 'imagecreatetruecolor';
            $copy	= 'imagecopyresampled';
        }
        else
        {
            $create	= 'imagecreate';
            $copy	= 'imagecopyresized';
        }

        $dst_img = $create(isset($this->dst_creat_width) ? $this->dst_creat_width :$this->width,
        isset($this->dst_creat_height) ? $this->dst_creat_height : $this->height);

        $white = imagecolorallocate($dst_img, 255, 255, 255);
        imagefill($dst_img, 0, 0, $white);
        unset($white);
        if ($this->image_type == 3) // png we can actually preserve transparency
        {
            imagealphablending($dst_img, FALSE);
            imagesavealpha($dst_img, TRUE);
        }

        $copy($dst_img, $src_img, $x, $y, $this->x_axis, $this->y_axis, $this->width, $this->height, $this->orig_width, $this->orig_height);

        //  Show the image
        if ($this->dynamic_output == TRUE)
        {
            $this->image_display_gd($dst_img);
        }
        else
        {
            // Or save it
            if ( ! $this->image_save_gd($dst_img))
            {
                return FALSE;
            }
        }

        //  Kill the file handles
        imagedestroy($dst_img);
        imagedestroy($src_img);

        // Set the file to 777
        @chmod($this->full_dst_path, FILE_WRITE_MODE);

        return TRUE;
    }

}