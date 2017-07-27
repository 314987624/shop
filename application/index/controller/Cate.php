<?php
namespace app\index\controller;

use think\Db;

class Cate extends Common
{
    public function index($id = 0)
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
            ->order('id','desc')
            ->paginate(8);
        $this->assign([
            'cate_list' => $cate_list,
            'cate_pos' => $cate_pos,
            'goods_list' => $goods_list
        ]);
        return $this->fetch();
    }
}
