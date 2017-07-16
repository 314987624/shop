<?php
namespace app\admin\controller;

use think\Db;
use think\exception\ErrorException;
use think\Request;

class Cate extends Common
{

    protected $cate;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->cate = new \app\admin\model\Cate();
    }

    public function index()
    {
        $list = $this->cate->cate_tree();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        if($this->request->isPost()){
            $data = $this->request->post();
            @$recid = $data['recid'];
            unset($data['recid']);
            $ret = $this->cate->validate(
                [
                    'cate_name' => 'require|max:20'
                ],
                [
                    'cate_name.require' => '不能为空',
                    'cate_name.max' => '名称不能超过20个字符'
                ]
            )->insertGetId($data);
            if($ret){
                //推荐位
                if($recid != null){
                    foreach($recid as $v){
                        Db::table('recvalue')->insert([
                            'valueid' => $ret,
                            'recid' => $v,
                            'rectype' => 2
                        ]);
                    }
                }
                $this->success('添加成功',url('Cate/index'));
            }else{
                $this->error('添加失败:'.$this->cate->getError());
            }
        }else{
            $list = $this->cate->cate_tree();
            $recpos_list = Db::table('recpos')->where('rectype',2)->select();
            $this->assign('list',$list);
            $this->assign('recpos_list',$recpos_list);
            return $this->fetch();
        }
    }

    public function edit($id = null)
    {
        if($this->request->isPost()){
            try{
                $data = $this->request->post();
                @$recid = $data['recid'];
                unset($data['recid']);
                $this->cate->validate(
                    [
                        'cate_name' => 'require|max:20'
                    ],
                    [
                        'cate_name.require' => '不能为空',
                        'cate_name.max' => '名称不能超过20个字符'
                    ]
                )->isUpdate(true)->save($data);
                Db::table('recvalue')->where(['valueid'=>$id,'rectype'=>2])->delete();
                //推荐位
                if($recid != null){
                    foreach($recid as $v){
                        Db::table('recvalue')->insert([
                            'valueid' => $id,
                            'recid' => $v,
                            'rectype' => 2
                        ]);
                    }
                }
                $this->success('修改成功','index');
            }catch(ErrorException $e){
                $this->error('修改失败');
            }
        }else{
            if(is_numeric($id)){
                $list = $this->cate->cate_tree();
                $data = $this->cate->get($id);
                $recpos_list = Db::table('recpos')->where('rectype',2)->select();
                $recid = Db::table('recvalue')->field('recid')->where(['valueid'=>$id,'rectype'=>2])->select();
                $recids = array();
                foreach($recid as $v){
                    $recids[] = $v['recid'];
                }
                $this->assign('data', $data);
                $this->assign('list', $list);
                $this->assign('recpos_list',$recpos_list);
                $this->assign('recids',$recids);
                return $this->fetch();
            }else{
                $this->error('非法操作');
            }
        }
    }

    public function del($id = null)
    {
        if(is_numeric($id)){
            Db::table('recvalue')->where(['valueid'=>$id,'rectype'=>2])->delete();
            $affected = $this->cate->del($id);
            if($affected){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法操作');
        }
    }

}
