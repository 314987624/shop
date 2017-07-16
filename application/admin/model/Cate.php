<?php

namespace app\admin\model;

use think\Model;

class Cate extends Model
{
    //栏目树
    public function cate_tree()
    {
        $data = $this->all();
        return $this->resort($data);
    }
    //栏目树排序
    public function resort($data, $pid=0, $level=0)
    {
        static $arr;
        foreach($data as $v){
            if($v['pid'] == $pid){
                $v['level'] = $level;
                $arr[] = $v;
                $this->resort($data, $v['id'], $level+1);
            }
        }
        return $arr;
    }
    //删除数据
    public function del($id)
    {
        $data = $this->all();
        $arr = $this->getChild($data ,$id);
        $arr[] = intval($id);
        $affected = $this->destroy($arr);
        return $affected;
    }
    //获取子栏目的id
    public function getChild($data, $id){
        static $arr;
        foreach ($data as $v){
            if($v['pid'] == $id){
                $arr[] = $v['id'];
                $this->getChild($data, $v['id']);
            }
        }
        return $arr;
    }
}
