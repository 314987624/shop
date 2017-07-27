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

    //获取顶级栏目
    public function getParentCate($id)
    {
        static $data;
        $cate = $this->find($id)->data;
        if($cate['pid'] != 0){
            $this->getParentCate($cate['pid']);
        }else{
            $data = $cate;
        }
        return $data;
    }

    //获取所有子栏目
    public function getChildrenCate($id){
        $data = Db::table('cate')->where('pid',$id)->select();
        foreach($data as $k => $v){
            $data[$k]['child'] = Db::table('cate')->where('pid',$v['id'])->select();
            foreach($data[$k]['child'] as $k2 => $v2){
                $data[$k]['child'][$k2]['child'] = Db::table('cate')->where('pid',$v2['id'])->select();
            }
        }
        return $data;
    }

    //获取栏目路径
    public function getCatePos($id)
    {
        static $data = [];
        $cate = $this->find($id)->data;
        $data[] = $cate;
        if($cate['pid'] != 0){
            $this->getCatePos($cate['pid']);
        }
        sort($data);
        return $data;
    }
    //获取所有子栏目ID
    public function getChildrenCateIds($id)
    {
        $ids[] = $id;
        $data = Db::table('cate')->where('pid',$id)->select();
        foreach($data as $k => $v){
            $ids[] = $v['id'];
            $data[$k]['child'] = Db::table('cate')->where('pid',$v['id'])->select();
            foreach($data[$k]['child'] as $k2 => $v2){
                $ids[] = $v2['id'];
                $data[$k]['child'][$k2]['child'] = Db::table('cate')->where('pid',$v2['id'])->select();
                foreach($data[$k]['child'][$k2]['child'] as $k3 => $v3){
                    $ids[] = $v3['id'];
                }
            }
        }
        return $ids;
    }

}
