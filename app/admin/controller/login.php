<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\BaseController;
use think\captcha\facade\Captcha;
use think\facade\Db;
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
        $admin = Db::connect('qiusuo')->table('admin')->where('username', $username)->find();
        if (!$admin) //用户不存在
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

        session('admin', $admin);
        //登陆成功
        return json(['code'=>0, 'msg'=>'登陆成功'] );
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
