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
 * @version    $Id socket_helper.php v1.0.0 12-3-20 下午10:44 $
 */

// ------------------------------------------------------------------------

/**
 * dfsockopen Helpers
 *
 * @package     Maotin
 * @subpackage  Helpers
 * @category    Extends Helpers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.maotin.com/
 */

/**
 * 建立socket连接
 *
 * @param $hostname
 * @param int $port
 * @param $errno
 * @param $errstr
 * @param int $timeout
 * @return resource|string
 */
if( ! function_exists('fsocketopen'))
{
    function fsocketopen($hostname, $port = 80, &$errno, &$errstr, $timeout = 15)
    {
        $fp = '';
        if(function_exists('fsockopen'))
        {
            $fp = @fsockopen($hostname, $port, $errno, $errstr, $timeout);
        }
        elseif(function_exists('pfsockopen'))
        {
            $fp = @pfsockopen($hostname, $port, $errno, $errstr, $timeout);
        }
        elseif(function_exists('stream_socket_client'))
        {
            $fp = @stream_socket_client($hostname.':'.$port, $errno, $errstr, $timeout);
        }
        return $fp;
    }
}

/**
 * 建立socket请求
 *
 * @param $url
 * @param int $limit
 * @param string $post
 * @param string $cookie
 * @param string $ip
 * @param int $timeout
 * @param bool $block
 * @return string
 */
if( ! function_exists('dfsockopen'))
{
    function dfsockopen($url,
                        $limit   = 0,
                        $post    = '',
                        $cookie  = '',
                        $ip      = '',
                        $timeout = 15,
                        $block   = TRUE)
    {
        $return  = '';
        $matches = parse_url($url);
        $scheme  = $matches['scheme'];
        $host    = $matches['host'];
        $path    = $matches['path'] ? $matches['path'] . (isset($matches['query']) && $matches['query'] ? '?' . $matches['query'] : '') : '/';
        $port    = ! empty($matches['port']) ? $matches['port'] : 80;

        if($post)
        {
            $out     = "POST $path HTTP/1.0\r\n";
            $header  = "Accept: */*\r\n";
            $header .= "Accept-Language: zh-cn\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
            $header .= "Host: $host\r\n";
            $header .= 'Content-Length: ' . strlen($post) . "\r\n";
            $header .= "Connection: Close\r\n";
            $header .= "Cache-Control: no-cache\r\n";
            $header .= "Cookie: $cookie\r\n\r\n";
            $out    .= $header . $post;
        }
        else
        {
            $out     = "GET $path HTTP/1.0\r\n";
            $header  = "Accept: */*\r\n";
            $header .= "Accept-Language: zh-cn\r\n";
            $header .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
            $header .= "Host: $host\r\n";
            $header .= "Connection: Close\r\n";
            $header .= "Cookie: $cookie\r\n\r\n";
            $out    .= $header;
        }

        $fpflag = 0;
        if(!$fp = @fsocketopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout))
        {
            $context = array(
                    'http'    => array(
                    'method'  => $post ? 'POST' : 'GET',
                    'header'  => $header,
                    'content' => $post,
                    'timeout' => $timeout,
                ),
            );
            $context = stream_context_create($context);
            $fp      = @fopen($scheme . '://' . ($ip ? $ip : $host) . ':' . $port . $path, 'b', false, $context);
            $fpflag  = 1;
        }

        if(!$fp)
        {
            return '';
        }
        else
        {
            stream_set_blocking($fp, $block);
            stream_set_timeout($fp, $timeout);
            @fwrite($fp, $out);
            $status = stream_get_meta_data($fp);
            if(!$status['timed_out'])
            {
                while (!feof($fp) && !$fpflag)
                {
                    if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))
                    {
                        break;
                    }
                }

                $stop = false;
                while(!feof($fp) && !$stop)
                {
                    $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                    $return .= $data;
                    if($limit)
                    {
                        $limit -= strlen($data);
                        $stop = $limit <= 0;
                    }
                }
            }
            @fclose($fp);
            return $return;
        }
    }
}

/* End of file socket_helper.php */
/* Location: ./application/helpers/socket_helper.php */