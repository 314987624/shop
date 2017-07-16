<?php
namespace app\admin\controller;

use app\admin\model\Manager;
use think\Request;

class Index extends Common
{
    public function index()
    {
        return $this->fetch();
    }

    public function info()
    {
        return $this->fetch();
    }

    public function edit(Request $request)
    {
        if($request->isPost()){
            $input = $request->post();
            $manager = new Manager();
            $data = $manager->where(['username' => session('username')])->find();
            if($data->getData('password') == md5($input['old_password'])){
                if($input['password'] == $input['password2']){
                    $affected = $data->save(['password' => md5($input['password'])]);
                    if($affected){
                        $this->success('修改成功',url('index/index'));
                    }else{
                        $this->error('修改失败');
                    }
                }else{
                    $this->error('两次密码不一致');
                }
            }else{
                $this->error('原始密码错误');
            }
        }else {
            return $this->fetch();
        }
    }

}
