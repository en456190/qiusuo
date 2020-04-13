<?php


namespace app\admin\controller;


use app\admin\model\Admin as AdminModel;

use think\facade\Session;
use think\facade\View;
use app\admin\common\Base;

class index extends Base
{
    public function index()
    {
        $admin = Session::get('admin');
        View::assign('data', $admin);
        return View::fetch('index');
    }

    //我的页面
    public function welcome()
    {
        $admin = Session::get('admin');
        View::assign('data', $admin);
        return View::fetch('welcome');
    }


    public function welcome1()
    {
        return View::fetch('welcome1');
    }


}