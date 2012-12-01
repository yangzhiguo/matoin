<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Maotin System
 *
 * 猫头鹰Maotin - 寻找最有价值的东西
 *
 * Maotin - to help you find the most valuable thing
 *
 * @package    Maotin
 * @author     yzg <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2011 - 2012, maotin.com.
 * @license    GNU General Public License 2.0
 * @link       http://www.maotin.com/
 * @version    $Id filei_helper.php v1.0.0 12-6-17 上午9:15 $
 */

// ------------------------------------------------------------------------

/**
 * filei Helpers
 *
 * @package     Maotin
 * @subpackage  Helpers
 * @category    Extends Helpers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */

/**
 * 取得文件的后缀名
 *
 * @param $file
 * @return mixed
 */
if( ! function_exists('fileext'))
{
    function fileext($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }
}

/**
 * 创建目录
 *
 * @param $dir
 * @param int $mode
 * @param bool $makeindex
 * @return bool
 */
if( ! function_exists('dmkdir'))
{
    function dmkdir($dir, $mode = 0777, $makeindex = TRUE)
    {
        if(!is_dir($dir))
        {
            dmkdir(dirname($dir), $mode, $makeindex);
            @mkdir($dir, $mode);
            if($makeindex)
            {
                @touch($dir . DIRECTORY_SEPARATOR . 'index.html');
                @chmod($dir . DIRECTORY_SEPARATOR . 'index.html', 0777);
            }
        }
        return TRUE;
    }
}

/**
 * 取得缩略图地址
 *
 * @param string $file_name
 * @param string $thumb_info
 * @return string
 */
if( ! function_exists('get_thumb_name'))
{
    function get_thumb_name($file_name, $thumb_info = '')
    {
        $extension = fileext($file_name);
        return rtrim($file_name, '.' . $extension) . $thumb_info . '.' . $extension;
    }
}

/* End of file filei_helper.php */
/* Location: ./application/helpers/filei_helper.php */