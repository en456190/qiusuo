<?php


namespace app\admin\controller;


use app\BaseController;
use think\facade\View;
use app\admin\common\Base;

class index extends Base
{
    public function index()
    {
        return View::fetch('index');
    }

    public function welcome()
    {
        return View::fetch('welcome');
    }



}