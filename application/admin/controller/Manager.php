<?php

namespace app\admin\controller;

use think\Request;

class Manager extends Common
{

    protected $manager;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->manager = new \app\admin\model\Manager();
    }

    public function index()
    {
        $list = $this->manager->all(function($query){
            $query->field('id,username');
        });
        $this->assign('list',$list);
        return $this->fetch();
    }


}
