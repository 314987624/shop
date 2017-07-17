<?php
namespace app\index\controller;

use app\index\model\Car;

class Flow extends Common
{
    public function addToCar()
    {
        $data = request()->post();
        $attrId = implode(',',$data['attr']);
        $car = new Car();
        $car->addToCar($data['goods_id'],$attrId,$data['number']);
        $this->success('添加成功','flow1');
    }

    public function flow1()
    {
        $car = new Car();
        $goodsInfo = $car->getGoodsInfo();
        //halt($goodsInfo);
        $this->assign('goodsInfo',$goodsInfo);
        return $this->fetch();
    }
}
