<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Goods extends Model
{
    public function goods_list(){
        $data = $this->alias('g')
            ->join('cate c','g.cate_id = c.id','LEFT')
            ->join('brand b','g.brand_id = b.id','LEFT')
            ->field('g.id,goods_name,sm_thumb,
            market_price,shop_price,
            onsale,cate_name,brand_name')->order('id desc')->paginate(5);
        return $data;
    }

    public function goods_attr_list($goods_id){
        $data = Db::table('goods_attr')->alias('g')->where('g.goods_id',$goods_id)
            ->join('attr a','g.attr_id = a.id and a.attr_type = 1')
            ->field('g.id,g.attr_id,g.attr_value,a.attr_name')->order('g.id asc')->select();
        $arr = array();
        foreach($data as $k => $v){
           $arr[$v['attr_id']][] = $v;
        }
        return $arr;
    }

    public function member_price($goods_id){
        $data = Db::table('member_price')->alias('p')->where('goods_id',$goods_id)
            ->join('member_level l','p.level_id = l.id')
            ->field('p.id,p.price,l.level_name')->select();
        return $data;
    }
}
