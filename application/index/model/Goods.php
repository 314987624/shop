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
}
