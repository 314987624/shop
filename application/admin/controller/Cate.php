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
            $data['attr_id'] = array_unique($data['attr_id']);
            foreach($data['attr_id'] as $k => $v){
                if($v == '0'){
                    unset($data['attr_id'][$k]);
                }
            }
            $data['search_attr_id'] = implode(',',$data['attr_id']);
            @$recid = $data['recid'];
            unset($data['recid']);
            unset($data['type_id']);
            unset($data['attr_id']);
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
            $type_list = Db::table('type')->select();
            $this->assign('list',$list);
            $this->assign('recpos_list',$recpos_list);
            $this->assign('type_list',$type_list);
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
                $data['attr_id'] = array_unique($data['attr_id']);
                foreach($data['attr_id'] as $k => $v){
                    if($v == '0'){
                        unset($data['attr_id'][$k]);
                    }
                }
                $data['search_attr_id'] = implode(',',$data['attr_id']);
                unset($data['attr_id']);
                unset($data['type_id']);
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
                $data = $this->cate->get($id)->toArray();
                $recpos_list = Db::table('recpos')->where('rectype',2)->select();
                $recid = Db::table('recvalue')->field('recid')->where(['valueid'=>$id,'rectype'=>2])->select();
                $recids = array();
                foreach($recid as $v){
                    $recids[] = $v['recid'];
                }
                $type_list = Db::table('type')->select();
                $attr = Db::table('attr')->where(['id'=>['in',$data['search_attr_id']]])->select();
                if(!$attr){
                    $attr[0]['type_id'] = 0;
                }
                $attr_all = Db::table('attr')->where('type_id',$attr[0]['type_id'])->select();
                $this->assign('data', $data);
                $this->assign('list', $list);
                $this->assign('recpos_list',$recpos_list);
                $this->assign('recids',$recids);
                $this->assign('type_list',$type_list);
                $this->assign('attr',$attr);
                $this->assign('attr_all',$attr_all);
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

    public function ajaxGetAttr($type_id)
    {
        $data = Db::table('attr')->where('type_id',$type_id)->select();
        return $data;
    }

}
