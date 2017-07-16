<?php
namespace app\admin\controller;

use think\Db;

class AdPos extends Common
{

    public function index()
    {
        $list = Db::table('ad_pos')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = Db::table('ad_pos')->insert($data);
            if($ret){
                $this->success('添加成功',url('ad_pos/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
    }

    public function edit($id = null)
    {
        if(is_numeric($id)){
            if($this->request->isPost()){
                $data = $this->request->post();
                $ret = Db::table('ad_pos')->update($data);
                if($ret){
                    $this->success('修改成功',url('ad_pos/index'));
                }else{
                    $this->error('修改失败');
                }
            }else{
                $data = Db::table('ad_pos')->find($id);
                $this->assign('data',$data);
                return $this->fetch();
            }
        }else{
            $this->error('非法操作');
        }
    }

    public function del($id = null)
    {
        if(is_numeric($id)){
            $ret = Db::table('ad_pos')->delete($id);
            if($ret){
                $this->success('删除成功',url('ad_pos/index'));
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法操作');
        }
        return $this->fetch();
    }

}
