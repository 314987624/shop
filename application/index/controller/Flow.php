<?php
namespace app\index\controller;

use app\index\model\Car;
use app\index\model\Product;
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
        dump($goodsInfo);
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
        //锁机制
        $fp = fopen('./order.lock','r');
        flock($fp,LOCK_EX);
        //检查库存
        $car = new Car();
        $goodsInfo = $car->getGoodsInfo();
        $product = new Product();
        $weight = 0;
        foreach($goodsInfo as $k => $v){
            $weight += $v['weight'];
            $arr = explode('-',$k);
            $num = $product->getProduct($arr[0],$arr[1]);
            if($num < $v['number']){
                flock($fp,LOCK_UN);
                fclose($fp);
                $this->error($v['goods_name'].' 的库存不足，请减少商品数量！');
                die;
            }
        }
        if($data['pay'] == '余额'){
            $money = Db::table('member')->where('id',session('uid'))->field('money')->find();
            if($money >= $data['tprice']){
                Db::table('member')->where('id',session('uid'))->setDec('money',$data['tprice']);
                $data['pay_status'] = 1;
            }else{
                flock($fp,LOCK_UN);
                fclose($fp);
                $this->error('余额不足，提交失败');
            }
        }
        $data['sn'] = time().rand(111111,999999);
        $data['addtime'] = time();
        $data['mid'] = session('uid');
        $data['yprice'] = psjg($data['peisong'],$weight,$data['province'],$data['city'],$data['county']);
        $data['tprice'] = $data['gtprice'] + $data['yprice'];
        $order_id = Db::table('order')->insertGetId($data);
        if($order_id){
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
                $product->where(['goods_id'=>$arr[0],'goods_attr'=>$arr[1]])
                    ->setDec('goods_number',$v['number']);
            }
            cookie('car',null);
            flock($fp,LOCK_UN);
            fclose($fp);
            $this->success('提交成功','flow4');
        }else{
            flock($fp,LOCK_UN);
            fclose($fp);
            $this->error('提交失败');
        }
    }

    public function flow4()
    {
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
