<?php

namespace app\index\model;

use think\Db;
use think\Model;

class Goods extends Model
{
    public function getRecGoods($recid,$limit)
    {
        $valueid = Db::table('recvalue')->field('valueid')->where('recid',$recid)->limit($limit)->select();
        $arr = array();
        foreach($valueid as $k => $v){
            $arr[] = $v['valueid'];
        }
        $data = $this->where(['id'=>['in',$arr]])->select();
        return $data;
    }

    //属性筛选
    public function getSearchAttr($cate_id)
    {
        //品牌
        $cate = new Cate();
        $cate_ids = $cate->getChildrenCateIds($cate_id);
        $map['cate_id'] = ['in',$cate_ids];
        $brand = $this->alias('g')->join('brand b','g.brand_id = b.id')
            ->field('DISTINCT b.id,b.brand_name')->where($map)->select()->toArray();
        //价格
        $shop_price = $this->field('max(shop_price) as max_price,min(shop_price) as min_price')
            ->find()->toArray();
        $cha = ceil(($shop_price['max_price'] - $shop_price['min_price'])/5);
        $price = [];
        for($i=0; $i<5; $i++){
            if($i == 4){
                $price[] = intval($shop_price['min_price']).'-'.intval($shop_price['max_price']);
            }else{
                $price[] = intval($shop_price['min_price']).'-'.($shop_price['min_price']+$cha);
                $shop_price['min_price'] += $cha;
            }
        }
        //属性
        $cate = Db::table('cate')->field('search_attr_id')->find($cate_id);
        $attr = Db::table('attr')->field('id,attr_name')->where(['id'=>['in',$cate['search_attr_id']],'attr_type'=>1])->select();
        foreach($attr as $k => $v){
            $attr_value = Db::table('goods_attr')->field('DISTINCT attr_id,attr_value')->where(['attr_id'=>$v['id']])->select();
            if(!$attr_value){
                unset($attr[$k]);
            }else{
                foreach($attr_value as $k2 => $v2){
                    $value = Db::table('attr_value')->where(['attr_id'=>$v2['attr_id'],'attr_value'=>$v2['attr_value']])->find();
                    $attr_value[$k2]['id'] = $value['id'];
                }
                $attr[$k]['value'] = $attr_value;
            }
        }
        return [
            'brand' => $brand,
            'price' => $price,
            'attr' => $attr
        ];
    }

}
