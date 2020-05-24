<?php
/**
 * Created by PhpStorm.
 * User: asus-pc
 * Date: 2020/4/26
 * Time: 0:55
 */

namespace app\index\model;


use think\Model;

class Brief extends Model
{
    protected $connection = 'qiusuo';

    /**
     * 数据表名称
     * @var string
     */
    protected $table = 'brief_introduction';
}