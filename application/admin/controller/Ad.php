<?php
namespace app\admin\controller;

use think\Db;

class Ad extends Common
{

    public function index()
    {
        $list = Db::table('ad')
            ->alias('a')
            ->join('ad_pos p','a.posid = p.id','LEFT')
            ->field('a.id,a.name,a.type,a.posid,p.pname,a.ison')
            ->select();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        if($this->request->isPost()){
            $data = $this->request->post();
            $links = $data['links'];
            unset($data['links']);
            if(isset($data['ison'])){
                $data['ison'] = 1;
            }else{
                $data['ison'] = 0;
            }
            $picurl = $this->upload('picurl');
            if($picurl != null){
                $data['picurl'] = $picurl;
            }
            $ret = Db::table('ad')->insertGetId($data);
            $ad_pic = $this->uploads('imgurl',$links,$ret);
            if($ad_pic != null){
                Db::table('ad_pic')->insertAll($ad_pic);
            }
            if($ret){
                $this->success('添加成功',url('ad/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $pos_list = Db::table('ad_pos')->select();
            $this->assign('pos_list',$pos_list);
            return $this->fetch();
        }
    }

    public function edit($id = null)
    {
        if(is_numeric($id)){
            if($this->request->isPost()){
                try{
                    $data = $this->request->post();
                    if($data['type'] == '1'){
                        $picurl = $this->upload('picurl');
                        if($picurl != null){
                            $p = Db::table('ad')->field('picurl')->find($id);
                            @unlink($p['picurl']);
                            $data['picurl'] = $picurl;
                        }
                    }else{
                        if(isset($data['links'])){
                            $links = $data['links'];
                            unset($data['links']);
                            $ad_pic = $this->uploads('imgurl',$links,$id);
                            if($ad_pic != null){
                                Db::table('ad_pic')->insertAll($ad_pic);
                            }
                        }
                        $old_links = $data['old_links'];
                        unset($data['old_links']);
                        $this->picEdit($old_links);
                    }
                    if(isset($data['ison'])){
                        $data['ison'] = 1;
                    }else{
                        $data['ison'] = 0;
                    }
                    Db::table('ad')->update($data);
                    $this->success('修改成功',url('ad/index'));
                }catch(\ErrorException $e){
                    $this->error('修改失败：'.$e);
                }
            }else{
                $data = Db::table('ad')->find($id);
                $pos_list = Db::table('ad_pos')->select();
                $pic_list = Db::table('ad_pic')->where('adid',$id)->select();
                $this->assign('data',$data);
                $this->assign('pos_list',$pos_list);
                $this->assign('pic_list',$pic_list);
                return $this->fetch();
            }
        }else{
            $this->error('非法操作');
        }
    }

    public function del($id = null)
    {
        if(is_numeric($id)){
            $ret = Db::table('ad')->delete($id);
            if($ret){
                $this->success('删除成功',url('ad/index'));
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法操作');
        }
        return $this->fetch();
    }

    //图片上传
    protected function upload($name)
    {
        $file = $this->request->file($name);
        if($file){
            $dir = './uploads/ad/';
            $save_name = rand().time().rand();
            $info = $file->validate(['ext'=>'jpg,png,gif'])->move($dir,$save_name);
            if($info){
                $filename = $info->getSaveName();
                return $dir.$filename;
            }else{
                echo $file->getError();
            }
        }else{
            return null;
        }
    }

    //多图上传
    protected function uploads($arr,$links,$adid)
    {
        $files = request()->file($arr);
        $dir = './uploads/ad/';
        $data = array();
        foreach($files as $k => $file){
            $save_name = rand().time().rand();
            $info = $file->validate(['ext'=>'jpg,png,gif'])->move($dir,$save_name);
            if($info){
                $filename = $info->getSaveName();
                $data[] = [
                    'imgurl' => $dir.$filename,
                    'links' => $links[$k],
                    'adid' => $adid
                ];
            }else{
                echo $file->getError();
            }
        }
        return $data;
    }

    //多图修改
    protected function picEdit($links)
    {
        $dir = './uploads/ad/';
        foreach($links as $k => $v){
            $files = request()->file('old_imgurl'.$k);
            if($files){
                echo $files;
                $save_name = rand().time().rand();
                $info = $files->validate(['ext'=>'jpg,png,gif'])->move($dir,$save_name);
                $i = Db::table('ad_pic')->field('imgurl')->find($k);
                @unlink($i['imgurl']);
                $filename = $info->getSaveName();
                Db::table('ad_pic')->update([
                    'imgurl' => $dir.$filename,
                    'links' => $v,
                    'id' => $k
                ]);
            }else{
                Db::table('ad_pic')->update([
                    'links' => $v,
                    'id' => $k
                ]);
            }
        }
    }

    public function ajaxDelImg($id)
    {
        if(is_numeric($id)){
            $i = Db::table('ad_pic')->field('imgurl')->find($id);
            @unlink($i['imgurl']);
            Db::table('ad_pic')->delete($id);
        }
    }

}
