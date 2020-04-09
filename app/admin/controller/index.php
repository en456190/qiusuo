<?php


namespace app\admin\controller;


use app\BaseController;
use think\facade\View;


class index extends BaseController
{
    public function index()
    {
        //return 111;
        return View::fetch('index');
    }

    public function welcome()
    {
        return View::fetch('welcome');
    }



}