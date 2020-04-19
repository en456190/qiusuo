<?php


namespace app\admin\model;


use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    use SoftDelete;
    protected $connection = 'qiusuo';

    public  function adminrole()
    {
        return $this->belongsTo(Admin_role::class, 'groupid', 'id');
    }
}