<?php
namespace app\admin\controller;

use think\Db;

class MemberLevel extends Common
{
    public function index()
    {
        $list = Db::table('member_level')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){
            $input = request()->post();
            $ret = Db::table('member_level')->insert($input);
            if($ret){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
    }

    public function edit($id)
    {
        if(request()->isPost()){
            $input = request()->post();
            $ret = Db::table('member_level')->update($input);
            if($ret){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }else{
            if(is_numeric($id)){
                $data = Db::table('member_level')->find($id);
                $this->assign('data',$data);
                return $this->fetch();
            }else{
                $this->error('非法操作');
            }
        }
    }

    public function del($id)
    {
        if(is_numeric($id)){
            $ret = Db::table('member_level')->delete($id);
            if($ret){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法操作');
        }
    }

}
