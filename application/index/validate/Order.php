<?php
namespace app\index\validate;

use think\Validate;

class Order extends Validate
{
    protected $rule = [
        'shr' => 'require',
        'province' => 'require',
        'city' => 'require',
        'county' => 'require',
        'adress' => 'require',
        'phone' => 'require'
    ];

    protected $message = [
        'shr.require' => '收货人不能为空',
        'province.require' => '请选择省份',
        'city.require' => '请选择市',
        'county.require' => '请选择县区',
        'adress.require' => '详细地址不能为空',
        'phone.require' => '电话不能为空'
    ];
}