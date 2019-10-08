<?php
/**
 * Created by Eric-Nothing.
 * Date: 2019/10/8
 * Time: 13:32
 */

/**
 * 生成指定长度邀请码
 */
if (!function_exists('build_invite_code')) {
    function build_invite_code($len = 8)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        mt_srand(10000000 * (double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars) - 1; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }
}

/**
 * 生成订单号
 */
if (!function_exists('build_order_n')) {
    function build_order_n(string $pre)
    {
        $str = $pre . date('YmdHis') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 1);
        echo $str;
    }
}
