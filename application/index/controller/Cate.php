<?php
namespace app\index\controller;

use app\index\model\Goods;
use think\Db;

class Cate extends Common
{
    public function index($id = 0, $od = 'id', $ow = 'desc', $attr = null)
    {
        $cate = new \app\index\model\Cate();
        $cate_list = $cate->getCate();
        $cate_pos = [];
        if($id != null){
            $cate_pos = $cate->getCatePos($id);
        }
        $ids = $cate->getChildrenCateIds($id);
        //筛选属性
        $goodsIdAttr = null;
        if($attr){
            $attr = explode('.',$attr);
            foreach($attr as $k => $v){
                if($v != 0){
                    $attr_id = Db::table('attr_value')->field('attr_id,attr_value')->find($v);
                    $goods_id = Db::table('goods_attr')->field('GROUP_CONCAT(goods_id) goods_id')->where($attr_id)->find();
                    $goods_id = explode(',',$goods_id['goods_id']);
                    if($goodsIdAttr == null){
                        $goodsIdAttr = $goods_id;
                    }else{
                        $goodsIdAttr = array_intersect($goodsIdAttr,$goods_id);
                        if(empty($goodsIdAttr)){
                            break;
                        }
                    }
                }
            }
        }
        $map['cate_id'] = ['in',$ids];
        if($goodsIdAttr){
            $map['id'] = ['in',$goodsIdAttr];
        }
        $goods_list = Db::table('goods')->where($map)
            ->field('id,goods_name,mid_thumb,market_price,shop_price')
            ->order($od,$ow)
            ->paginate(8);
        $goods = new Goods();
        $filter = $goods->getSearchAttr($id);
        $this->assign([
            'cate_list' => $cate_list,
            'cate_pos' => $cate_pos,
            'goods_list' => $goods_list,
            'od' => $od,
            'ow' => $ow,
            'filter' => $filter,
            'id' => $id,
        ]);
        return $this->fetch();
    }
}
