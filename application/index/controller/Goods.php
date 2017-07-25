<?php
namespace app\index\controller;

use app\index\model\Cate;
use app\index\model\Product;
use think\Db;

class Goods extends Common
{
    public function index($id)
    {
        $data = Db::table('goods')->alias('g')
            ->join('brand b','g.brand_id = b.id')
            ->field('g.*,b.brand_name,b.brand_url')
            ->where('g.id',$id)->find();
        $goods_pic = Db::table('goods_pic')->where('goods_id',$id)->select();
        $goods_attr = Db::table('goods_attr')->where('goods_id',$id)
            ->alias('g')->join('attr a','g.attr_id = a.id')
            ->field('g.*,a.attr_name,a.attr_type')->select();
        $only_attr = array();
        $radio_attr = array();
        foreach($goods_attr as $k => $v){
            if($v['attr_type'] == 0){
                $only_attr[] = $v;
            }else{
                $radio_attr[$v['attr_id']][] = $v;
            }
        }
        $cate = new Cate();
        $parent_cate = $cate->getParentCate($data['cate_id']);
        $cate_list = $cate->getChildrenCate($parent_cate['id']);
        $this->assign([
            'data' => $data,
            'goods_pic' => $goods_pic,
            'only_attr' => $only_attr,
            'radio_attr' => $radio_attr,
            'cate_list' => $cate_list
        ]);
        return $this->fetch();
    }
    //总共的库存
    public function ajaxSumProduct($goods_id)
    {
        if(request()->isAjax()){
            $product =  new Product();
            $sum = $product->sumProduct($goods_id);
            if($sum){
                return json(['sum'=>$sum]);
            }else{
                return json(['sum'=>0]);
            }
        }else{
            $this->error('非法操作');
        }
    }
    //某一属性的库存
    public function ajaxGetProduct($goods_id,$goods_attr = '')
    {
        if(request()->isAjax()){
            $product =  new Product();
            $num = $product->getProduct($goods_id,$goods_attr);
            if($num){
                return json(['num'=>$num]);
            }else{
                return json(['num'=>0]);
            }
        }else{
            $this->error('非法操作');
        }
    }
}
