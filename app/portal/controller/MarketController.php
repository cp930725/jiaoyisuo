<?php 
namespace app\portal\controller;
use cmf\controller\HomeBaseController;
use think\Db;
/**
 * 前台交易控制器
 */
class MarketController extends HomeBaseController
{
	/**
     * 首页
     */
    public function grondID()
    {
        
    }
    public function index()
    {
        //获取币种数据
        $currency = Db::name('currency')
                    ->alias('c')
                    ->leftjoin('currency ct','ct.currency_id = c.trade_currency_id')
                    ->field('c.currency_id,c.currency_mark,ct.currency_mark as ct_mark')
                    ->select();
        $this->assign('currency',$currency);
        return $this->fetch();
    }

    /**
     * 卖出交易记录
     * @param int $currency_id 买入币种id
     */
    public function data1($currency_id)
    {
        $data = Db::name('trade')
                ->alias('t')
                ->leftjoin('currency c','c.currency_id = t.currency_id')
                ->field('t.num,t.price * t.num as total_price') //无手续费
                ->where('type','sell')
                ->where('t.currency_id',$currency_id)
                ->select();
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 买入交易记录
     * @param int $currency_id 卖出币种id
     */
    public function deta($currency_id)
    {
        $deta = Db::name('trade')
                ->alias('t')
                ->leftjoin('currency c','c.currency_id = t.currency_id')
                ->field('t.num,t.price * t.num as total_price') //无手续费
                ->where('type','buy')
                ->where('t.currency_id',$currency_id)
                ->select();
        $this->assign('deta',$deta);
        return$this->fetch();
    }

    /**
     * 买入
     */
    public function purchase()
    {
        //判断用户是否登陆
        // $userphone = session('userphone');
        // if(empty($userphone)){
        //     return $this->error('请先登录',url('my/login'));
        // }
        $userphone = 15132123456;
        $currency_id = $this->request->param('currency_id');
        $currency = Db::name('currency')
                    ->alias('c')
                    ->leftjoin('currency ct','ct.currency_id = c.trade_currency_id')
                    ->field('c.currency_id,c.currency_mark,c.trade_currency_id,ct.currency_mark as ct_mark,ct.currency_id as ct_id')
                    ->where('c.currency_id',$currency_id)
                    ->find();
        $this->assign('currency',$currency);
        if($currency['trade_currency_id'] == 0){
            $number = Db::name('member')->field('rmb as num,forzen_rmb as forzen_num')->where('phone',$userphone)->find();
        }else{
            $number = Db::name('currency_user')->field('num,forzen_num')->where('userphone',$userphone)->where('currency_id',$currency['trade_currency_id'])->find();
        }
        $this->assign('number',$number);
        return $this->fetch();
    }

    /**
     * 卖出
     */
    public function sell_out()
    {
        //判断用户是否登陆
        // $userphone = session('userphone');
        // if(empty($userphone)){
        //     return $this->error('请先登录',url('my/login'));
        // }
        $userphone = 15132123456;
        $currency_id = $this->request->param('currency_id');
        $currency = Db::name('currency')
                    ->alias('c')
                    ->leftjoin('currency ct','ct.currency_id = c.trade_currency_id')
                    ->field('c.currency_id,c.currency_mark,c.trade_currency_id,ct.currency_mark as ct_mark,ct.currency_id as ct_id')
                    ->where('c.currency_id',$currency_id)
                    ->find();
        $this->assign('currency',$currency);
        if($currency['trade_currency_id'] == 0){
            $number = Db::name('member')->field('rmb as num,forzen_rmb as forzen_num')->where('phone',$userphone)->find();
        }else{
            $number = Db::name('currency_user')->field('num,forzen_num')->where('userphone',$userphone)->where('currency_id',$currency['trade_currency_id'])->find();
        }
        $this->assign('number',$number);
        return $this->fetch();
    }

    /**
     * 当前委托
     */
    public function current()
    {
        return $this->fetch();
    }

    /**
     * 全部委托
     */
    public function whole()
    {
        return $this->fetch();
    }
}