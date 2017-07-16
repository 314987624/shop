<?php
namespace app\index\controller;

use app\index\model\Cate;

class Category extends Common
{
    public function index()
    {
        $cate = new Cate();
        $cate_list = $cate->getCate();
        $this->assign('cate_list',$cate_list);
        return $this->fetch();
    }
}
