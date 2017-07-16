<?php
namespace app\admin\controller;

use app\admin\model\Cate;
use think\Db;
use think\Image;

class Goods extends Common
{
    public $goods;

    public function _initialize()
    {
        parent::_initialize();
        $this->goods = new \app\admin\model\Goods();
    }

    public function index()
    {
        $list = $this->goods->goods_list();
        $this->assign('list',$list);
        return $this->fetch();
    }

    //添加商品
    public function add()
    {
        if(request()->isPost()){
            $data = request()->post();
            @$recid = $data['recid'];
            unset($data['recid']);
            $mps = $data['mps'];
            unset($data['mps']);
            @$attr_value = $data['attr_value'];
            @$attr_price = $data['attr_price'];
            unset($data['attr_value']);
            unset($data['attr_price']);
            $file = $this->upload('file');
            if($file != null){
                $data = array_merge($data,$file);
            }
            $data['goods_sn'] = time().rand(111111,999999);
            $ret = Db::table('goods')->insertGetId($data);
            if($ret){
                //推荐位
                if($recid != null){
                    foreach($recid as $v){
                        Db::table('recvalue')->insert([
                            'valueid' => $ret,
                            'recid' => $v,
                            'rectype' => 1
                        ]);
                    }
                }
                //会员价格
                foreach($mps as $k => $v){
                    Db::table('member_price')->insert([
                        'price' => $v,
                        'level_id' => $k,
                        'goods_id' => $ret
                    ]);
                }
                //商品属性
                if($attr_value != null){
                    $attr = array();
                    foreach($attr_value as $k => $v){
                        foreach($v as $kk => $vv){
                            $arr['goods_id'] = $ret;
                            $arr['attr_id'] = $k;
                            $arr['attr_value'] = $vv;
                            $arr['attr_price'] = $attr_price[$k][$kk];
                            $attr[] = $arr;
                        }
                    }
                    Db::table('goods_attr')->insertAll($attr);
                }
                //商品图片
                $r = $this->uploads('files',$ret);
                if(!empty($r)){
                    Db::table('goods_pic')->insertAll($r);
                }
                $this->success('添加成功',url('goods/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $cate = new Cate();
            $cate_list = $cate->cate_tree();
            $brand_list = Db::table('brand')->field('id,brand_name')->select();
            $level_list = Db::table('member_level')->field('id,level_name')->select();
            $type_list = Db::table('type')->select();
            $recpos_list = Db::table('recpos')->select();
            $this->assign([
                'level_list' => $level_list,
                'brand_list' => $brand_list,
                'cate_list' => $cate_list,
                'type_list' => $type_list,
                'recpos_list' => $recpos_list
            ]);
            return $this->fetch();
        }
    }

    //编辑商品
    public function edit($id = null)
    {
        if(is_numeric($id)){
            if(request()->isPost()){
                try{
                    $data = request()->post();
                    @$recid = $data['recid'];
                    unset($data['recid']);
                    $mps = $data['mps'];
                    unset($data['mps']);
                    @$attr_value = $data['attr_value'];
                    @$attr_price = $data['attr_price'];
                    unset($data['attr_value']);
                    unset($data['attr_price']);
                    $old_attr_value = $data['old_attr_value'];
                    $old_attr_price = $data['old_attr_price'];
                    $old_attr_id = $data['old_attr_id'];
                    unset($data['old_attr_value']);
                    unset($data['old_attr_price']);
                    unset($data['old_attr_id']);
                    $file = $this->upload('file');
                    if($file != null){
                        $data = array_merge($data,$file);
                        $img = Db::table('goods')->field('original,sm_thumb,mid_thumb,max_thumb')
                            ->where('id',$id)->find();
                        @unlink($img['original']);
                        @unlink($img['sm_thumb']);
                        @unlink($img['mid_thumb']);
                        @unlink($img['max_thumb']);
                    }
                    Db::table('goods')->where('id',$id)->update($data);
                    //推荐位
                    Db::table('recvalue')->where(['valueid'=>$id,'rectype'=>1])->delete();
                    if($recid != null){
                        foreach($recid as $v){
                            Db::table('recvalue')->insert([
                                'valueid' => $id,
                                'recid' => $v,
                                'rectype' => 1
                            ]);
                        }
                    }
                    //会员价格
                    foreach($mps as $k => $v){
                        Db::table('member_price')->update([
                            'id' => $k,
                            'price' => $v
                        ]);
                    }
                    //商品属性添加
                    if($attr_value != null){
                        $attr = array();
                        foreach($attr_value as $k => $v){
                            foreach($v as $kk => $vv){
                                $arr['goods_id'] = $id;
                                $arr['attr_id'] = $k;
                                $arr['attr_value'] = $vv;
                                $arr['attr_price'] = $attr_price[$k][$kk];
                                $attr[] = $arr;
                            }
                        }
                        Db::table('goods_attr')->insertAll($attr);
                    }
                    //商品属性修改
                    if($old_attr_value != null){
                        foreach($old_attr_value as $k => $v){
                            foreach($v as $kk => $vv){
                                Db::table('goods_attr')->update([
                                    'attr_value' => $vv,
                                    'attr_price' => $old_attr_price[$k][$kk],
                                    'id' => $old_attr_id[$k][$kk]
                                ]);
                            }
                        }
                    }
                    //商品图片
                    $r = $this->uploads('files',$id);
                    if(!empty($r)){
                        Db::table('goods_pic')->insertAll($r);
                    }
                }catch(\Exception $e){
                    $this->error('执行错误');
                }
                $this->success('修改成功',url('goods/index'));
            }else{
                $data = $this->goods->get($id);
                $cate = new Cate();
                $cate_list = $cate->cate_tree();
                $brand_list = Db::table('brand')->field('id,brand_name')->select();
                $member_price = $this->goods->member_price($id);
                $type_list = Db::table('type')->select();
                $attr_list = Db::table('attr')->where('type_id',$data['type_id'])->select();
                $goods_attr = Db::table('goods_attr')->where('goods_id',$id)->select();
                $goods_attr_list = array();
                foreach($goods_attr as $k => $v){
                    $goods_attr_list[$v['attr_id']][] = $v;
                }
                $goods_pic = Db::table('goods_pic')->where('goods_id',$id)
                    ->field('id,sm_thumb')->select();
                $recpos_list = Db::table('recpos')->where('rectype',1)->select();
                $recid = Db::table('recvalue')->field('recid')->where(['valueid'=>$id,'rectype'=>1])->select();
                $recids = array();
                foreach($recid as $v){
                    $recids[] = $v['recid'];
                }
                $this->assign([
                    'data' => $data,
                    'brand_list' => $brand_list,
                    'cate_list' => $cate_list,
                    'member_price' => $member_price,
                    'type_list' => $type_list,
                    'attr_list' => $attr_list,
                    'goods_attr_list' => $goods_attr_list,
                    'goods_pic' => $goods_pic,
                    'recpos_list' => $recpos_list,
                    'recids' => $recids
                ]);
                return $this->fetch();
            }
        }else{
            $this->error('非法操作');
        }
    }

    //删除商品
    public function del($id = null){
        if(is_numeric($id)){
            Db::table('member_price')->where('goods_id',$id)->delete();
            Db::table('goods_attr')->where('goods_id',$id)->delete();
            $logo = Db::table('goods')->field('original,sm_thumb,mid_thumb,max_thumb')->find($id);
            @unlink($logo['original']);
            @unlink($logo['sm_thumb']);
            @unlink($logo['mid_thumb']);
            @unlink($logo['max_thumb']);
            $pic = Db::table('goods_pic')->where('goods_id',$id)->select();
            foreach($pic as $k => $v){
                @unlink($v['original']);
                @unlink($v['sm_thumb']);
                @unlink($v['max_thumb']);
            }
            Db::table('goods_pic')->where('goods_id',$id)->delete();
            Db::table('recvalue')->where(['valueid'=>$id,'rectype'=>1])->delete();
            $ret = Db::table('goods')->delete($id);
            if($ret){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法操作');
        }
    }

    //库存
    public function product($goods_id = null){
        if(request()->isPost()){
            Db::table('product')->where('goods_id',$goods_id)->delete();
            $input = request()->post();
            $data = array();
            foreach($input['goods_number'] as $k => $v){
                $attr = array();
                foreach($input['goods_attr'] as $v2){
                    if($v2[$k] == ''){
                        continue 2;
                    }
                    $attr[] = $v2[$k];
                }
                $attr = implode(',',$attr);
                $data[] = [
                    'goods_id' => $goods_id,
                    'goods_number' => $v,
                    'goods_attr' => $attr
                ];
            }
            $ret = Db::table('product')->insertAll($data);
            if($ret){
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            }
        }else{
            if(is_numeric($goods_id)){
                $goods_attr_list = $this->goods->goods_attr_list($goods_id);
                $product_list = Db::table('product')->where('goods_id',$goods_id)->order('id asc')->select();
                $this->assign('goods_attr_list',$goods_attr_list);
                $this->assign('product_list',$product_list);
                return $this->fetch();
            }else{
                $this->error('非法操作');
            }
        }
    }

    //图片上传 缩略
    protected function upload($name)
    {
        $file = $this->request->file($name);
        if($file){
            $dir = './uploads/goods/';
            $save_name = rand().time().rand();
            $info = $file->validate(['ext'=>'jpg,png,gif'])->move($dir,$save_name);
            if($info){
                $filename = $info->getSaveName();
                $image = Image::open($dir.$filename);
                $image->thumb(350,350)->save($dir.'max_'.$filename);
                $image->thumb(222,222)->save($dir.'mid_'.$filename);
                $image->thumb(56,56)->save($dir.'sm_'.$filename);
                $data = [
                    'original' => $dir.$filename,
                    'max_thumb' => $dir.'max_'.$filename,
                    'mid_thumb' => $dir.'mid_'.$filename,
                    'sm_thumb' => $dir.'sm_'.$filename
                ];
                return $data;
            }else{
                echo $file->getError();
            }
        }
    }

    //多图上传
    protected function uploads($arr,$goods_id)
    {
        $files = request()->file($arr);
        $dir = './uploads/goods/';
        $data = array();
        foreach($files as $file){
            $save_name = rand().time().rand();
            $info = $file->validate(['ext'=>'jpg,png,gif'])->move($dir,$save_name);
            if($info){
                $filename = $info->getSaveName();
                $image = Image::open($dir.$filename);
                $image->thumb(350,350)->save($dir.'max_'.$filename);
                $image->thumb(56,56)->save($dir.'sm_'.$filename);
                $data[] = [
                    'original' => $dir.$filename,
                    'max_thumb' => $dir.'max_'.$filename,
                    'sm_thumb' => $dir.'sm_'.$filename,
                    'goods_id' => $goods_id
                ];
            }else{
                echo $file->getError();
            }
        }
        return $data;
    }
    //获取属性
    public function ajaxGetAttr($type_id){
        if(request()->isAjax()){
            $data = Db::table('attr')->where('type_id',$type_id)->select();
            return json($data);
        }
    }
    //删除图片
    public function ajaxDelPic($id){
        if(request()->isAjax()){
            $pic = Db::table('goods_pic')->where('id',$id)->find();
            @unlink($pic['original']);
            @unlink($pic['sm_thumb']);
            @unlink($pic['max_thumb']);
            Db::table('goods_pic')->delete($id);
        }
    }
    //商城商品属性
    public function ajaxDelGoodsAttr($id){
        Db::table('goods_attr')->delete($id);
    }
}
