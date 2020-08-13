<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/11/2
 * Time: 10:36
 */
namespace app\index\controller;

use think\Controller;

class Base extends Controller
{
    public $city;
    public $account;
    public function _initialize()
    {
        $citys = model('City')->getNormalCitys();

        $sign = input('sign',0,'intval');
        $this->getCity($citys);
        //获取首页分类数据
        $cats = $this->getRecommendCats();
        $this->assign('citys', $citys);
        $this->assign('city', $this->city);
        $this->assign('cats',$cats);
        $this->assign('controller',strtolower(request()->controller()));
        $this->assign('user', $this->getLoginUser());
        $this->assign('title','o2o团购网');
        $this->assign('sign',$sign);
    }

    public function getCity($citys)
    {
        foreach ($citys as $city) {
            $city = $city->toArray();
            if ($city['is_default'] == 1) {
                $defaultuname = $city['uname'];
                break;
            }
        }
        $defaultuname = $defaultuname ? $defaultuname : 'nanchangshi';

        if (session('cityuname','','o2o') && !input('get.city')){
            $cityuname = session('cityuname','','o2o');
        }else{
            $cityuname  = input('get.city',$defaultuname,'trim');

            session('cityuname',$cityuname,'o2o');
        }
       $this->city =  model('City')->where(['uname'=>$cityuname])->find();
    }


    public function getLoginUser()
    {
        if (!$this->account){
            $this->account = session('o2o_user','','o2o');
        }

        return $this->account;
    }

    /**4
     * 获取首页分类推荐的商品数据
     */
    public function getRecommendCats()
    {
        $parentIds = $sedcatArr = $recomCats = [];
       $cats =  model('Category')->getNormalRecommendCategoryByParentId();

        foreach ($cats as $cat){
            $parentIds[] = $cat->id;
        }
        //获取二级分类数据
       $sedCats =  model('Category')->getNormalCategoryIdParentId($parentIds);
        foreach ($sedCats as $sedcat){
            $sedcatArr[$sedcat->parent_id][] = [
              'id'=>$sedcat->id,
                'name'=>$sedcat->name
            ];
        }

        foreach ($cats as $cat){
            //  $recomCats 代表的是一级和二级数据
            $recomCats[ $cat->id] = [$cat->name,
                empty($sedcatArr[$cat->id]) ? []:$sedcatArr[$cat->id]];
        }

        return $recomCats;
    }









}
