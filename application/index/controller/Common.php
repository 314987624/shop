<?php
namespace app\index\controller;

use phpDocumentor\Reflection\DocBlockTest;
use think\Controller;
use think\Db;

class Common extends Controller
{
    public function _initialize()
    {
        $this->getHelp();
        $this->getNav();
        $this->siteConfig();
    }
    //获取帮助栏目
    protected function getHelp()
    {
        $help = Db::table('category')->where('type',1)->select();
        foreach($help as $k => $v){
            $help[$k]['article'] = Db::table('article')->where('cate_id',$v['id'])->select();
        }
        $this->assign('help',$help);
    }
    //获取导航
    protected function getNav()
    {
        $nav = Db::table('nav')->select();
        $arr = array();
        foreach($nav as $k => $v){
            $arr[$v['nav_pos']][] = $v;
        }
        if(isset($arr[1])){
            $this->assign('top_nav',$arr[1]);
        }
        if(isset($arr[2])){
            $this->assign('mid_nav',$arr[2]);
        }
        if(isset($arr[3])){
            $this->assign('bot_nav',$arr[3]);
        }
    }
    //获取配置
    protected function siteConfig()
    {
        $data = Db::table('config')->field('enname,value')->select();
        $site_config = array();
        foreach($data as $v){
            $site_config[$v['enname']] = $v['value'];
        }
        $this->assign('site_config',$site_config);
    }

}