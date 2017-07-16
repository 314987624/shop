<?php

namespace app\admin\validate;

use think\Validate;

class Goods extends Validate
{
    protected $rule = [
        'goods_name' => 'require|max:30',
        'market_price' => 'number',
        'shop_price' => 'number',
        'goods_weight' => 'number'
    ];
    protected $message = [
        'goods_name.require' => '名称不能为空'
    ];
}
