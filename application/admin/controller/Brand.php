<?php
namespace app\admin\controller;

use think\Image;
use think\Request;

class Brand extends Common
{
    public $brand;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->brand = new \app\admin\model\Brand();
    }

    public function index()
    {
        $list = $this->brand->all();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        if($this->request->isPost()){
            $input = $this->request->post();
            $file = $this->upload('file');
            if($file != null){
                $input['brand_logo'] = $file;
            }
            $affected = $this->brand->save($input);
            if($affected){
                $this->success('添加成功',url('brand/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
    }

    public function edit($id = null)
    {
        if($this->request->isPost()){
            $input = $this->request->post();
            $filename = $this->upload('file');
            if($filename != null){
                $input['brand_logo'] = $filename;
            }
            $affected = $this->brand->isUpdate(true)->save($input);
            if($affected){
                $this->success('修改成功', url('brand/index'));
            }else{
                $this->error('修改失败');
            }
        }else{
            if(is_numeric($id)){
                $data = $this->brand->get($id);
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
            $logo = $this->brand->field('brand_logo')->find($id);
            @unlink($logo['brand_logo']);
            $affected = $this->brand->get($id)->delete();
            if($affected){
                $this->success('删除成功',url('brand/index'));
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法操作');
        }
        return $this->fetch();
    }

    //图片上传 缩略
    protected function upload($name)
    {
        $file = $this->request->file($name);
        if($file){
            $dir = './uploads/brand/';
            $save_name = rand().time().rand();
            $info = $file->validate(['ext'=>'jpg,png,gif'])->move($dir,$save_name);
            if($info){
                $filename = $info->getSaveName();
                $image = Image::open($dir.$filename);
                $image->thumb(150,100)->save($dir.$filename);
                return $dir.$filename;
            }else{
                echo $file->getError();
            }
        }else{
            return null;
        }
    }

}
