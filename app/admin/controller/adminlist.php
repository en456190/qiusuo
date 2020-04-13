<?php
declare (strict_types = 1);

namespace app\admin\controller;

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
    public function index()
    {
        //按照升序获取管理员列表
        $adminlist = AdminModel::order('id')->paginate(6);;
        return View::fetch('adminlist', ['adminlist' => $adminlist]);
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
