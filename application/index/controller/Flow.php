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
        $goodsInfo = $car->getGoodsInfo();;
        $this->assign('goodsInfo',$goodsInfo);
        return $this->fetch();
    }

    public function ajaxDelGoods($key)
    {
        if(request()->isAjax()){
            $car = new Car();
            $car->delGoods($key);
        }else{
            $this->error('非法操作');
        }
    }

    public function ajaxUpdateCar($key,$num)
    {
        if(request()->isAjax()){
            $car = new Car();
            $car->updateCar($key,$num);
        }else{
            $this->error('非法操作');
        }
    }

    public function ajaxClearCar()
    {
        if(request()->isAjax()){
            $car = new Car();
            $car->clearCar();
        }else{
            $this->error('非法操作');
        }
    }
}
