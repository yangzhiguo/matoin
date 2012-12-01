<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yzg
 * Date: 12-6-26
 * Time: 下午3:03
 * To change this template use File | Settings | File Templates.
 */

/**
 * 字符串加密、解密函数
 *
 * @param	string	$txt		字符串
 * @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
 * @param	string	$key		密钥：数字、字母、下划线
 * @return	string
 */
if( ! function_exists('encrypt'))
{
    function encrypt($txt, $operation = 'ENCODE', $inurl = FALSE, $key = '')
    {
        $G_SEARCH  = array('/', '=', '+');
        $G_REPLACE = array('L_L', 'D_D', 'P_P');
        $key = $key ? $key : config_item('encryption_key');
        if($operation == 'DECODE')
        {
            if($inurl == TRUE)
            {
                $txt = str_replace($G_REPLACE, $G_SEARCH, $txt);
            }
            $txt = base64_decode($txt);
        }
        $len  = strlen($key);
        $tlen = strlen($txt);
        $code = '';
        for($i = 0; $i <$tlen; $i ++)
        {
            $k     = $i % $len;
            $code .= $txt[$i] ^ $key[$k];
        }
        if($operation == 'ENCODE')
        {
            $code = base64_encode($code);
            if($inurl == TRUE)
            {
                $code = str_replace($G_SEARCH, $G_REPLACE, $code);
            }
        }
        return $code;
    }
}
