<?php


namespace app\admin\common;


use app\BaseController;
use think\App;
use think\facade\Session;

class Base extends BaseController
{
    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->admin = Session::get('admin');
        if (!$this->admin)
        {
            header('Location: /admin/login/index');
            exit;
        }
    }
}