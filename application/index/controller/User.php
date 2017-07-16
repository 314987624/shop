<?php
namespace app\index\controller;

use think\Db;

class User extends Common
{
    public function reg()
    {
        if(session('?uname')){
            $this->redirect('index/index','','302');
            die;
        }
        if(request()->isPost()){
            $data = request()->post();
            if(!isset($data['agreement'])){
                $this->error('必须接受用户协议');
                die;
            }
            if(!captcha_check($data['captcha'])){
                $this->error('验证码错误');
                die;
            }
            $validate = $this->validate($data,'Member');
            if(true !== $validate){
                $this->error($validate);
            }else{
                unset($data['captcha']);
                unset($data['repassword']);
                unset($data['agreement']);
                $data['password'] = md5($data['password']);
                $data['mail_str'] = md5(uniqid());
                $data['regtime'] = time();
                $res = Db::table('member')->insert($data);
                if($res){
                    $content = '<a href="http://tp5.com/index/user/check_mail/es/'.$data['mail_str'].'">欢迎'.$data['username'].'注册解学渊博客，点击此连接进行邮箱验证：http://tp5.com/index/user/check_mail/es/'.$data['mail_str'].'</a>';
                    sendMail($data['email'],'用户注册验证',$content);
                    session('uname',$data['username']);
                    $this->success('注册成功','index/index');
                }else{
                    $this->error('注册失败');
                }
            }
        }else{
            return $this->fetch();
        }
    }

    public function login()
    {
        if(session('?uname')){
            $this->redirect('index/index','','302');
            die;
        }
        if(request()->isPost()){
            $data = request()->post();
            if(!captcha_check($data['captcha'])){
                $this->error('验证码错误');
                die;
            }
            $res = Db::table('member')->where('username',$data['username'])->find();
            if($res && $res['password'] == md5($data['password'])){
                session('uname',$res['username']);
                if(isset($data['remember'])){
                    $time = 3600 * 24;
                    cookie('username', $res['username'], $time);
                    cookie('password', $res['password'], $time);
                }
                $this->success('登录成功', url('index/index'));
            }else{
                $this->error('登录失败');
            }
        }else{
            return $this->fetch();
        }
    }

    public function quit()
    {
        if(!session('?uname')){
            $this->error('非法操作');
            die;
        }
        session('uname',null);
        cookie('username',null);
        cookie('password',null);
        $this->redirect('index/index','','302');
    }

    public function check_mail($es = null)
    {
        if(!empty($es)){
            $res = Db::table('member')->where('mail_str',$es)->find();
            if($res){
                Db::table('member')->where('mail_str',$es)->setField('check_mail',1);
                Db::table('member')->where('mail_str',$es)->setField('mail_str','');
                $this->success('验证成功','index/index');
            }else{
                $this->error('验证失败','reg');
            }
        }else{
            $this->error('非法操作');
        }
    }

    public function check_login()
    {
        if(request()->isAjax()){
            $uname = session('uname');
            if($uname){
                return json(['status' => 1 ,'username' => $uname]);
            }else{
                if(cookie('?username')){
                    $res = Db::table('member')->where('username',cookie('username'))->find();
                    if($res && $res['password'] == cookie('password')){
                        session('uname',$res['username']);
                        return json(['status' => 1 ,'username' => $res['username']]);
                    }
                }else{
                    return json(['status' => 0]);
                }
            }
        }else{
            $this->error('非法操作');
        }
    }

}
