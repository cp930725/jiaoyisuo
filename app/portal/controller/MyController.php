<?php 
namespace app\portal\controller;
use cmf\controller\HomeBaseController;
use think\Db;
/**
 * 个人中心控制器
 */
class MyController extends HomeBaseController
{
	/**
	 * 验证密码
	 */
	public function selectUser($userphone,$password,$safeword = null)
	{
		$query = Db::name('member')->field('member_id,pwd,pwdtrade')->where('phone','=',$userphone)->find();
		//按登陆密码查询
		if(!is_null($password)){
			$confirm = password_verify($password, $query['pwd']);
			return $confirm;
		}
		//按安全密码查询
		if(!is_null($safeword)){
			$confirm = password_verify($safeword, $query['pwdtrade']);
            return $confirm;
		}
	}

	/**
	 * 登录
	 */
	public function login()
	{
		$test = $this->request->param('type');
		if(!empty($test)){
			$userphone = $this->request->param('tel');
			$pass = $this->request->param('password');
			$confirm = $this->selectUser($userphone,$pass);
			if(empty($confirm)){
				return $this->error('登陆失败');
			}else{
				session('state',1);
				session('userphone',$userphone);
				$state = session('state');
				return $this->success('登陆成功',url('Market/index'));
			}
		}else{
			return $this->fetch('login');
		}
	}
}