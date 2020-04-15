<?php


namespace app\admin\common;


class Utils
{
    /**
     * 生成唯一标志
     *标准的UUID格式为：xxxxxxxx-xxxx-xxxx-xxxxxx-xxxxxxxxxx(8-4-4-4-12)
     */
    static function  uuid()
    {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr ( $chars, 0, 8 ) . '-'
            . substr ( $chars, 8, 4 ) . '-'
            . substr ( $chars, 12, 4 ) . '-'
            . substr ( $chars, 16, 4 ) . '-'
            . substr ( $chars, 20, 12 );
        return $uuid ;
    }
}