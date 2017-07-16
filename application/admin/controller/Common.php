<?php
namespace app\admin\controller;
use \think\Controller;

class Common extends Controller
{
	protected function _initialize()
	{
		if(session('?username') == null){
			$this->redirect('login/index','','302');
		}
	}

}
