<?php
namespace app\admin\controller;

use app\admin\model\Manager;
use think\Controller;
use think\Request;

class Login extends Controller
{
	public function Index(Request $request)
	{
		if(session('?username')){
			$this->redirect('index/index','','302');
			die;
		}
		if($request->isPost()){
			$input = $request->post();
			$manager = new Manager();
			if(!captcha_check($input['captcha'])){
				$this->error('验证码错误');
				die;
			}
			$result = $manager->where('username',$input['username'])->find();
			if($result && $result->getData('password') == md5($input['password'])){
				session('username',$result->getData('username'));
				$this->success('登录成功', url('index/index'));
			}else{
				$this->error('用户名或密码错误');
			}
		}else{
			return $this->fetch();
		}
	}

	public function quit()
	{
		if(!session('?username')){
			$this->error('非法操作');
			die;
		}
		session('username',null);
		$this->redirect('login/index','','302');
	}
}