<?php

namespace app\index\model;

use think\Db;
use think\Model;

class Cate extends Model
{
    public function getCate()
    {
        $data = Db::table('cate')->where('pid',0)->select();
        foreach($data as $k => $v){
            $data[$k]['child'] = Db::table('cate')->where('pid',$v['id'])->select();
            foreach($data[$k]['child'] as $k2 => $v2){
                $data[$k]['child'][$k2]['child'] = Db::table('cate')->where('pid',$v2['id'])->select();
            }
        }
        return $data;
    }
}
