<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\common\Utils;
use app\admin\model\Admin as AdminModel;
use app\admin\common\Base;
use think\facade\View;
use think\Request;

class adminlist extends Base
{
    /**
     * 显示管理员列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        //按照升序获取管理员列表
        $data['count'] = AdminModel::count(); //总数量
        $data['pagesize'] = 6;                //每页显示数量
        //管理员分页数据
        $data['adminlist'] = AdminModel::order('login_time', 'desc')->paginate($data['pagesize']);

        //当前页、以及总页数
        $currpage = $request->param('page');
        $data['currpage'] = (is_null($currpage) || $currpage <= 0) ? 1 : $currpage;

        View::assign('data', $data);

        return View::fetch('adminlist');
    }

    public function adminadd()
    {
        return View::fetch('adminadd');
    }
    /**
     * 增加管理员账户
     * @return json添加结果
     * @throws \Exception
     */
    public function adminsave(Request $request)
    {
        //$reqparam = $request->param();
        $data['id'] = Utils::uuid();
        $data['username'] = trim($request->param('username'));
        $data['password'] = trim($request->param('pass'));
        $repass = trim($request->param('repass'));
        $status = $request->param('status');
        $data['status'] = is_null($status) ? 0:$status;
        $data['login_time'] = date("Y-m-d H:i:s", time());
        $data['groupid'] = 1;

        //参数有效性检查
        if (('' == $data['username']) || ('' == $data['password']) || ('' == $repass))
        {
            return json(['code'=>1, 'msg'=>'请填写完整的参数'] );
        }

        //判断两次密码是否相同
        if (0 != strcmp($data['password'], $repass)) //
        {
            return json(['code'=>2, 'msg'=>'两次密码不一致']);
        }

        //检查用户名是否存在
        $admin = AdminModel::where('username', $data['username'])->find();
        //$admin = Db::connect('qiusuo')->table('admin')->where('username', $username)->find();
        if (false == is_null($admin)) //用户存在
        {
            return json(['code'=>3, 'msg'=>'用户已存在'] );
        }

        $admin = new AdminModel;
        if (false == $admin->save($data))
        {
            return json(['code'=>4, 'msg'=>'保存失败'] );
        }

        //登陆成功
        return json(['code'=>0, 'msg'=>'添加账户成功'] );
    }

    /**
     * 更新
     */
    public function adminupdate(Request $request)
    {
        $data['username'] = trim($request->param('username'));
        $data['status'] = $request->param('status');

        $admin = AdminModel::where('username', $data['username'])->find();
        if (is_null($admin))
        {
            return json(['code'=>1, 'msg'=>'要更新的账户不存在'] );
        }

        $admin->save(['status' => $data['status']]);
        return json(['code'=>0, 'msg'=>'更新成功'] );
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
