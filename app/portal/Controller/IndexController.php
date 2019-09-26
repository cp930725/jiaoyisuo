<?php
namespace app\portal\controller;

use cmf\controller\HomeBaseController;
use think\Request;
use think\Db;

/**
 *
 */
class IndexController extends HomeBaseController
{
    /**
     * app首页
     */
    public function index(Request $req)
    {
        //获取用户session状态 
        // $state = session('state');
        // if (empty($state)) {
        //     return $this->error('请登录后操作','My/login');
        // }
        // 查询对象, 显示首页数据
        // $currencies = Db::table('yang_currency')->select();
        // foreach ($currencies as $key => $value) {
            // $list             = $this->getCurrencyMessageById($value['currency_id']);
            // $currencies[$key] = array_merge($list, $currencies[$key]);
        // }
        // $this->assign('currencies', $currencies);

        if ($req->isPost()) {
            // 搜索币种
            $query = Db::table('yang_currency');
        }
        dump(121231231);
        return $this->fetch();
    }
}
