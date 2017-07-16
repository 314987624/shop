<?php
namespace app\index\controller;

use app\index\model\Cate;
use app\index\model\Goods;

class Index extends Common
{
    public function index()
    {
        $goods = new Goods();
        $newgoods = $goods->getRecGoods(2,5);//新品上架
        $hotgoods = $goods->getRecGoods(3,5);//热卖商品
        $bestgoods = $goods->getRecGoods(4,5);//精品推荐
        $cheapgoods = $goods->getRecGoods(7,4);//特价商品
        $cate = new Cate();
        $cate_list = $cate->getCate();
        $this->assign([
            'newgoods' => $newgoods,
            'hotgoods' => $hotgoods,
            'bestgoods' => $bestgoods,
            'cheapgoods' => $cheapgoods,
            'cate_list' => $cate_list
        ]);
        return $this->fetch();
    }
}
