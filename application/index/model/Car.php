<?php

namespace app\index\model;

use think\Db;
use think\Model;

class Car extends Model
{
    public function addToCar($goodsId,$attrId,$goodsNum)
    {
        $car = isset($_COOKIE['car']) ? unserialize($_COOKIE['car']): array();
        $key = $goodsId.'-'.$attrId;
        @$car[$key] += $goodsNum;
        $time = 3600 * 24 * 7;
        cookie('car',serialize($car),$time);
    }

    public function updateCar($key,$goodsNum)
    {
        $car = unserialize($_COOKIE['car']);
        $car[$key] = $goodsNum;
        $time = 3600 * 24 * 7;
        cookie('car',serialize($car),$time);
    }

    public function delGoods($key)
    {
        $car = unserialize($_COOKIE['car']);
        unset($car[$key]);
        $time = 3600 * 24 * 7;
        cookie('car',serialize($car),$time);
    }

    public function getGoodsInfo()
    {
        if(!cookie('?car')){
            return null;
        }
        $car = unserialize($_COOKIE['car']);
        $goodsInfo = [];
        foreach($car as $k => $v){
            $arr = explode('-',$k);
            $goods = Db::table('goods')->field('goods_name,mid_thumb,market_price,shop_price')->find($arr[0]);
            $goodsInfo[$k]['goods_name'] = $goods['goods_name'];
            $goodsInfo[$k]['mid_thumb'] = $goods['mid_thumb'];
            $goodsInfo[$k]['market_price'] = $goods['market_price'];
            $goodsInfo[$k]['shop_price'] = $goods['shop_price'];
            $goodsInfo[$k]['number'] = $v;
            $map['g.id'] = ['in',$arr[1]];
            $attr = Db::table('goods_attr')->alias('g')
                ->join('attr a','g.attr_id = a.id')
                ->field('a.attr_name,g.attr_value,g.attr_price')
                ->where($map)->select();
            $attr_price = 0;
            $attrs = [];
            foreach($attr as $v1) {
                if($v1['attr_price'] == 0){
                    $attrs[] = $v1['attr_name'].':'.$v1['attr_value'];
                }else{
                    $attrs[] = $v1['attr_name'].':'.$v1['attr_value'].' [+'.$v1['attr_price'].']';
                }
                $attr_price += $v1['attr_price'];
            }
            $goodsInfo[$k]['attr'] = implode('<br/>',$attrs);
            $goodsInfo[$k]['price'] = $goods['shop_price'] + $attr_price;
        }
        return $goodsInfo;
    }

    public function clearCar()
    {
        cookie('car',null);
    }
}
