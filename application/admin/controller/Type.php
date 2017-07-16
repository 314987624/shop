<?php
namespace app\admin\controller;

use think\Db;

class Type extends Common
{
    public function index()
    {
        $list = Db::table('type')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){
            $input = request()->post();
            $ret = Db::table('type')->insert($input);
            if($ret){
                $this->success('添加成功',url('type/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
    }

    public function edit($id = null)
    {
        if(request()->isPost()){
            $input = request()->post();
            $ret = Db::table('type')->update($input);
            if($ret){
                $this->success('修改成功', url('type/index'));
            }else{
                $this->error('修改失败');
            }
        }else{
            if(is_numeric($id)){
                $data = Db::table('type')->find($id);
                $this->assign('data',$data);
                return $this->fetch();
            }else{
                $this->error('非法操作');
            }
        }
    }

    public function del($id = null)
    {
        if(is_numeric($id)){
            Db::table('attr')->where('type_id',$id)->delete();
            $ret = Db::table('type')->delete($id);
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
