<?php


namespace app\admin\common;


use app\BaseController;
use think\App;

class Base extends BaseController
{
    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->admin = session('admin');
        if (!$this->admin)
        {
            header('Location: login/index');
            exit;
        }
    }
}