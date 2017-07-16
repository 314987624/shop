<?php
namespace app\admin\controller;

use think\Db;

class Article extends Common
{
    public function index()
    {
        $list = Db::table('article')->alias('a')
            ->join('category c','a.cate_id = c.id')
            ->field('a.id,a.title,c.name')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = Db::table('article')->insert($data);
            if($ret){
                $this->success('添加成功',url('article/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $category_list = Db::table('category')->select();
            $this->assign('category_list',$category_list);
            return $this->fetch();
        }
    }

    public function edit($id = null)
    {
        if(is_numeric($id)){
            if($this->request->isPost()){
                $data = $this->request->post();
                $ret = Db::table('article')->update($data);
                if($ret){
                    $this->success('修改成功',url('article/index'));
                }else{
                    $this->error('修改失败');
                }
            }else{
                $data = Db::table('article')->find($id);
                $category_list = Db::table('category')->select();
                $this->assign('data',$data);
                $this->assign('category_list',$category_list);
                return $this->fetch();
            }
        }else{
            $this->error('非法操作');
        }
    }

    public function del($id = null)
    {
        if(is_numeric($id)){
            $ret = Db::table('article')->delete($id);
            if($ret){
                $this->success('删除成功',url('article/index'));
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法操作');
        }
        return $this->fetch();
    }
}
