<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 20:08
 */
namespace app\index\controller;
use phpmailer\Email as email;
use think\Controller;

class Index extends Base
{

    public function test()
    {
        $email = new email();
        $email->send_email('zxf18770847936@126.com','zxf测试' ,'test1ceshi' );
        
    }
    public function index()
    {
       $map =  \Map::staticImage('118.074645,24.949172');


        //获取首页大图
        $indexImage = model('Featured')->getIndexImages();

//        dump($indexImage);exit();
        //获取广告位图片
        $rightImage = model('Featured')->where(['type'=>1,'status'=>1])->order(['listorder'=>'desc'])->limit(1)->select();

//        var_dump($rightImage[0]['image']);exit();

        //商品分类数据--> 美食 推荐数据
        $datas = model('Deal')->getNormalDealByCategoryCityId(1,$this->city->id);
        
//      dump($datas);exit();

        //获取四个子分类
        $meishicats = model('Category')->getNormalRecommendCategoryByParentId(1,4);


        $sign = input('sign',0,'intval');
        return $this->fetch('', [
            'indexImage'=>$indexImage,
            'rightImage'=>$rightImage,
            'datas'=> $datas,
            'meishicats'=>$meishicats,
            'sign'=>$sign
        ]);
    }


}
