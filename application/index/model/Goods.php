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
            ->field('b.id,b.brand_name')->where($map)->select()->toArray();
        dump($brand);
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
        dump($price);
    }

}
