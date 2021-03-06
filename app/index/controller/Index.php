<?php
namespace app\index\controller;

use app\BaseController;
use app\common\ComUtils;
use app\index\model\Brief;
use app\index\model\slide;
use think\facade\View;

class Index extends BaseController
{
    /**
     * 网站首页
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        $data = slide::where('type', 0)->select();
        $hotBriefs = Brief::where('order', 1)->select();
        $moreOrgan = Brief::where('order', 2)->select();
        View::assign('data', $data);
        View::assign('hotBriefs', $hotBriefs);
        View::assign('moreOrgan', $moreOrgan);

        dump(ComUtils::getCity());

        return View::fetch('index');
        //return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) 2020新春快乐</h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">14载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
    }

    public function login()
    {
        return View::fetch('login');
    }



//    public function hello($name = 'ThinkPHP6')
//    {
//        return 'hello,' . $name;
//    }
//
//    public function demo()
//    {
//        return View::fetch('demo');
//    }
}
