<?php
namespace app\index\validate;

use think\Validate;

class Member extends Validate
{
    protected $rule = [
        'username' => 'require|max:25|min:5|unique:member',
        'email' => 'require|email|unique:member',
        'password' => 'require|min:6',
        'repassword' => 'require|confirm:password'
    ];

    protected $message = [
        'username.require' => '名称不能为空',
        'username.max' => '名称最多不能超过25个字符',
        'username.min' => '名称长度不能小于5',
        'username.unique' => '此名称已占用',
        'email.require' => '邮箱不能为空',
        'email.email' => '邮箱格式错误',
        'email.unique' => '此邮箱已注册',
        'password.require' => '密码不能为空',
        'password.min' => '密码长度不能小于6',
        'repassword.require' => '重复密码不能为空',
        'repassword.confirm' => '两次密码不一致'
    ];
}