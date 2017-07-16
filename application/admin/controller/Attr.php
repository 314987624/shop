<?php
namespace app\admin\controller;

use think\Db;

class Attr extends Common
{
    public function index($type_id = null)
    {
        if(is_numeric($type_id)){
            $list = Db::table('attr')
                ->where('type_id',$type_id)
                ->select();
            $this->assign('list',$list);
        }else{
            $list = Db::table('attr')->select();
            $this->assign('list',$list);
        }
        $type_list = Db::table('type')->select();
        $this->assign('type_list',$type_list);
        $this->assign('type_id',$type_id);
        return $this->fetch();
    }

    public function add($type_id = null)
    {
        if(request()->isPost()){
            $input = request()->post();
            $input['attr_value'] = str_replace('，',',',$input['attr_value']);
            $ret = Db::table('attr')->insert($input);
            if($ret){
                $this->success('添加成功',url('attr/index',['type_id'=>$type_id]));
            }else{
                $this->error('添加失败');
            }
        }else{
            $type_list = Db::table('type')->select();
            $this->assign('type_list',$type_list);
            $this->assign('type_id',$type_id);
            return $this->fetch();
        }
    }

    public function edit($id = null)
    {
        if(request()->isPost()){
            $input = request()->post();
            $input['attr_value'] = str_replace('，',',',$input['attr_value']);
            $ret = Db::table('attr')->update($input);
            if($ret){
                $this->success('修改成功', url('attr/index',['type_id'=>$input['type_id']]));
            }else{
                $this->error('修改失败');
            }
        }else{
            if(is_numeric($id)){
                $data = Db::table('attr')->find($id);
                $this->assign('data',$data);
                $type_list = Db::table('type')->select();
                $this->assign('type_list',$type_list);
                return $this->fetch();
            }else{
                $this->error('非法操作');
            }
        }
    }

    public function del($id = null)
    {
        if(is_numeric($id)){
            Db::table('goods_attr')->where('attr_id',$id)->delete();
            $ret = Db::table('attr')->delete($id);
            if($ret){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法操作');
        }
        return $this->fetch();
    }

}
