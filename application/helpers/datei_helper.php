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
 * @since      Version ${VERSION} 2012-08-06 下午11:54 $
 * @filesource date_helper.php
 */

// ------------------------------------------------------------------------

/**
 * 人读格式化时间戳
 *
 * @param int $time
 * @return string
 */
if( ! function_exists('time_ago'))
{
    function time_ago($time, $no_nbsp = FALSE)
    {
        $nbsp = $no_nbsp ? '' : '&nbsp;';
        $formated_time = '';
        $past = TIME - $time;
        $tag_open  = '<span title="' . gmdate('Y-n-j H:i:s', $time) . '">';
        $tag_close = '</span>';

        if ($past < 60)
        {
            $formated_time = $past . $nbsp . lang('date_second');
        }
        else if ($past >= 60 && $past < 3600)
        {
            $formated_time = intval($past / 60) . $nbsp . lang('date_minute');
        }
        else if ($past >= 3600 && $past < 86400)
        {
            $formated_time = intval($past / 3600) . $nbsp . lang('date_hour');
        }
        else if ($past >= 86400 && $past < 2628000)
        {
            $formated_time = intval($past / 86400) . $nbsp . lang('date_day');
        }
        else if ($past>= 2628000 && $past < 31536000)
        {
            $formated_time = intval($past / 2628000) . $nbsp . lang('date_month');
        }
        else if($past>= 31536000)
        {
            $formated_time = intval($past / 31536000) . $nbsp . lang('date_year');
        }
        return $tag_open . $formated_time . lang('date_before') . $tag_close;
    }
}

/* End of file date_helper.php */
/* Location: ${FILE_PATH}/date_helper.php */