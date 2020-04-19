<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\common\Utils;
use app\admin\model\Admin as AdminModel;
use app\admin\common\Base;
use app\admin\model\Admin_role;
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
        $data['pagesize'] = 6;                //每页显示数量
        $username = $request->param('search');
        $data['username'] = is_null($username)? '':trim($username);

        if ('' == $data['username']) {
            $data['count'] = AdminModel::count(); //总数量
            //管理员分页数据
            $data['adminlist'] = AdminModel::order('login_time', 'desc')->paginate($data['pagesize']);
        }
        else
        {
            $data['count'] = AdminModel::whereLike('username', '%'.$data['username'].'%')->count(); //总数量
            //管理员分页数据
            $data['adminlist'] = AdminModel::whereLike('username', '%'.$data['username'].'%')->order('login_time', 'desc')->paginate($data['pagesize']);
        }

        //当前页、以及总页数
        $currpage = $request->param('page');
        $data['currpage'] = (is_null($currpage) || $currpage <= 0) ? 1 : $currpage;


        View::assign('data', $data);

        return View::fetch('adminlist');
    }

    /**
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function adminadd()
    {
        $admin_role = Admin_role::select();
        View::assign('admin_role', $admin_role);
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
        $data['phonenum'] = trim($request->param('phonenum'));
        $data['password'] = trim($request->param('pass'));
        $repass = trim($request->param('repass'));
        $status = $request->param('status');
        $data['status'] = is_null($status) ? 0:$status;
        $data['login_time'] = date("Y-m-d H:i:s", time());
        $data['groupid'] = (int)$request->param('role');

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
            return json(['code'=>4, 'msg'=>'账户添加失败'] );
        }

        //登陆成功
        return json(['code'=>0, 'msg'=>'账户添加成功'] );
    }

    /**
     * 更新账号状态
     * @return string
     * @throws \Exception
     */
    public function adminupdatestatus(Request $request)
    {
        $data['username'] = trim($request->param('username'));
        $data['status'] = $request->param('status');

        $admin = AdminModel::where('username', $data['username'])->find();
        if (is_null($admin))
        {
            return json(['code'=>1, 'msg'=>'要更新的账户不存在'] );
        }

        $admin->save(['status' => $data['status']]);
        return json(['code'=>0, 'msg'=>'状态更新成功'] );
    }

    /**
     * 显示管理员编辑页面
     * @return string
     * @throws \Exception
     */
    public function adminedit(Request $request)
    {
        $data['username'] = trim($request->param('username'));

        $admin = AdminModel::where('username', $data['username'])->find();
        if (is_null($admin))
        {
            return json(['code'=>1, 'msg'=>'要更新的账户不存在'] );
        }

        $admin_role = Admin_role::select();
        View::assign('admin_role', $admin_role);
        View::assign('admin', $admin);
        return View::fetch("adminedit");
    }

    /**
     * @param Request $request
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function admineditsave(Request $request)
    {
        $data['id'] = trim($request->param('id'));
        $data['username'] = trim($request->param('username'));
        $data['phonenum'] = trim($request->param('phonenum'));
        $data['password'] = trim($request->param('pass'));
        $repass = trim($request->param('repass'));
        $status = $request->param('status');
        $data['status'] = is_null($status) ? 0:$status;
        $data['login_time'] = date("Y-m-d H:i:s", time());
        $data['groupid'] = (int)$request->param('role');

        //参数有效性检查
        if (('' == $data['username']) || ('' == $data['password']) || ('' == $repass))
        {
            return json(['code'=>1, 'msg'=>'请填写用户名或密码'] );
        }

        //判断两次密码是否相同
        if (0 != strcmp($data['password'], $repass)) //
        {
            return json(['code'=>2, 'msg'=>'两次密码不一致']);
        }

        //查找对应的管理员信息
        $admin = AdminModel::where('username', $data['username'])->find();
        if (is_null($admin))
        {
            return json(['code'=>3, 'msg'=>'要更新的账户不存在'] );
        }

        if (false == $admin->save($data))
        {
            return json(['code'=>4, 'msg'=>'账户更新失败'] );
        }

        //登陆成功
        return json(['code'=>0, 'msg'=>'账户更新成功'] );
    }

    /**
     *
     */
    public function admindel(Request $request)
    {
        $ids = $request->param('ids');
        $usernames = json_decode($ids, true);
        if (is_array($usernames))
        {
            $where = 'username in ('.implode(',', $usernames).')';
        }
        else
        {
            $where = 'username =' ."'" . $usernames . "'";
        }

        /* 两种删除方式都可以 destory | delete */
//        $result = AdminModel::destroy(function($query) use ($where){
//            $query->where($where);
//        });

        $adminlist = AdminModel::where($where)->select();
        $result = $adminlist->delete();
        if (false == $result)
        {
            return json(['code'=>1, 'msg'=>'账户删除失败，请重试'] );
        }
        //删除成功
        return json(['code'=>0, 'msg'=>'账户删除成功'] );
    }

    /**
     *
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function adminrole()
    {

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
