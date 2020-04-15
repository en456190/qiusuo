<?php


namespace app\admin\controller;


use app\admin\model\Admin as AdminModel;

use think\facade\Session;
use think\facade\View;
use app\admin\common\Base;

class index extends Base
{
    /**
     * 显示后台管理主页面
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        $admin = Session::get('admin');
        View::assign('data', $admin);
        return View::fetch('index');
    }

    /**
     * 我的桌面
     * @return string
     * @throws \Exception
     */
    public function welcome()
    {
        $admin = Session::get('admin');
        View::assign('data', $admin);
        return View::fetch('welcome');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function welcome1()
    {
        return View::fetch('welcome1');
    }

}