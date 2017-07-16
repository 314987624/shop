<?php
namespace app\admin\controller;

use think\Db;

class Config extends Common
{

    public function index()
    {
        $list = Db::table('config')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){
            $data = request()->post();
            if($data['values'] != ''){
                $data['values'] = str_replace('，',',',$data['values']);
            }
            $ret = Db::table('config')->insert($data);
            if($ret){
                $this->success('添加成功','index');
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
                if($data['values'] != ''){
                    $data['values'] = str_replace('，',',',$data['values']);
                }
                $ret = Db::table('config')->update($data);
                if($ret){
                    $this->success('修改成功','index');
                }else{
                    $this->error('修改失败');
                }
            }else{
                $data = Db::table('config')->find($id);
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
            $ret = Db::table('config')->delete($id);
            if($ret){
                $this->success('删除成功','index');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法操作');
        }
        return $this->fetch();
    }

    public function site()
    {
        if($this->request->isPost()){
            $data = $this->request->post();
            foreach($data as $k => $v){
                Db::table('config')->where('enname',$k)->setField('value',$v);
            }
            $db = Db::table('config')->field('enname')->select();
            $dt = array_flip($data);
            foreach($db as $k => $v){
                if(!in_array($v['enname'],$dt)){
                    Db::table('config')->where('enname',$v['enname'])->setField('value','');
                }
            }
            $this->success('设置成功');
        }else{
            $list = Db::table('config')->select();
            $this->assign('list',$list);
            return $this->fetch();
        }
    }

}
