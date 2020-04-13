<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\Admin;
use app\BaseController;
use think\captcha\facade\Captcha;
use think\facade\Db;
use think\facade\Session;
use think\Request;
use think\facade\View;



class login extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return View::fetch('login');
    }

    /**
     * 显示登陆所用的验证码
     * @return \think\Response
     */
    public function verify()
    {
        //使用验证码功能，需要打开
        return Captcha::create('loginverify');
    }

    /**
     * 后台系统-登陆验证
     * @param Request $request
     * @return \think\response\Json
     */
    public function dologin(Request $request)
    {
        $data = $request->param();

        $username = $data['username'];
        $password = $data['password'];
        $verifycode = $data['verifycode'];

        //检验参数完整性
        if (('' == $username) || ('' == $password) || ('' == $verifycode))
        {
            return json(['code'=>1, 'msg'=>'请填写完整的参数'] );
        }

        //校验验证码
        if (false == captcha_check($verifycode))
        {
            return json(['code'=>2, 'msg'=>'验证码不正确'] );
        }

        //检查用户名和密码是否有效
        $admin = Admin::where('username', $username)->find();
        //$admin = Db::connect('qiusuo')->table('admin')->where('username', $username)->find();
        if (is_null($admin)) //用户不存在
        {
            return json(['code'=>3, 'msg'=>'用户不存在'] );
        }

        //检查用户名和密码是否匹配
        if (md5($username.$password) != md5($admin['username'].$admin['password']))
        {
            return json(['code'=>4, 'msg'=>'用户名或密码不对应'] );
        }

        //检查账户是否被禁用
        if ($admin['status'] != 0)
        {
            return json(['code'=>5, 'msg'=>'账户被禁用，请联系管理员'] );
        }

        $admin->save(['login_time' => date("Y-m-d H:i:s", time())]);
        Session::set('admin', $admin);
        //登陆成功
        return json(['code'=>0, 'msg'=>'登陆成功'] );
    }

    /**
     * 安全退出
     */
    public function dologout()
    {
        Session::delete('admin');

        return redirect('/admin/login/index');
    }
}
