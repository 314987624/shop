<?php
namespace app\index\controller;

use app\index\model\Car;
use think\Db;

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

    public function flow2()
    {
        if(session('?uname')){
            $car = new Car();
            $goodsInfo = $car->getGoodsInfo();
            $this->assign('goodsInfo',$goodsInfo);
            return $this->fetch();
        }else{
            session('resultUrl','flow/flow2');
            $this->error('请先登录',url('user/login'));
        }
    }

    public function flow3()
    {
        $data = request()->post();
        $r = $this->validate($data,'Order');
        if(true !== $r){
            $this->error($r);
            die;
        }
        $data['sn'] = time().rand(111111,999999);
        $data['addtime'] = time();
        $data['mid'] = session('uid');
        $order_id = Db::table('order')->insertGetId($data);
        if($order_id){
            $car = new Car();
            $goodsInfo = $car->getGoodsInfo();
            foreach($goodsInfo as $k => $v){
                $arr = explode('-',$k);
                $data2 = [
                    'goods_id' => $arr[0],
                    'goods_name' => $v['goods_name'],
                    'goods_attr_id' => $arr[1],
                    'goods_attr_str' => $v['attr'],
                    'goods_price' => $v['shop_price'],
                    'goods_marketprice' =>  $v['market_price'],
                    'goods_num' =>  $v['number'],
                    'order_id' =>  $order_id
                ];
                Db::table('order_goods')->insert($data2);
            }
            cookie('car',null);
            $this->success('提交成功','flow4');
        }else{
            $this->error('提交失败');
        }
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
