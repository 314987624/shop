<?php

namespace app\index\model;

use think\Db;
use think\Model;

class Product extends Model
{
    public function sumProduct($goods_id)
    {
        $sum = $this->where('goods_id',$goods_id)->sum('goods_number');
        return $sum;
    }
    public function getProduct($goods_id,$goods_attr='')
    {
        $product = $this->where(['goods_id'=>$goods_id,'goods_attr'=>$goods_attr])
            ->field('goods_number')
            ->find();
        if($product){
            return $product->data['goods_number'];
        }else{
            return 0;
        }
    }
}
