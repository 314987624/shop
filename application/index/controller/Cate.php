<?php
namespace app\index\controller;

use app\index\model\Goods;
use think\Db;

class Cate extends Common
{
    public function index($id = 0, $od = 'id', $ow = 'desc')
    {
        $cate = new \app\index\model\Cate();
        $cate_list = $cate->getCate();
        $cate_pos = [];
        if($id != null){
            $cate_pos = $cate->getCatePos($id);
        }
        $ids = $cate->getChildrenCateIds($id);
        $map['cate_id'] = array('in',$ids);
        $goods_list = Db::table('goods')->where($map)
            ->field('id,goods_name,mid_thumb,market_price,shop_price')
            ->order($od,$ow)
            ->paginate(8);
        $goods = new Goods();
        $search_attr = $goods->getSearchAttr($id);
        $this->assign([
            'cate_list' => $cate_list,
            'cate_pos' => $cate_pos,
            'goods_list' => $goods_list,
            'od' => $od,
            'ow' => $ow
        ]);
        return $this->fetch();
    }
}
