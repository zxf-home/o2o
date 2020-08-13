<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/11/2
 * Time: 13:58
 */
namespace app\index\controller;

class Lists extends Base
{
    public function index()
    {
        $fristCatIds = [];
        $categorys =model('Category')->getNormalCategoryByParentId();

        foreach ($categorys as $category){
            $fristCatIds[] = $category->id;
        }

        $id =input('id',0,'intval');

        $data = [];
        if (in_array($id, $fristCatIds)){//一级分类

            $categoryParentId = $id;
             $data['category_id'] = $id;

        }elseif($id){//二级分类
            //获取二级分类数据
            $category = model('Category')->get($id);
            if (!$category || $category->status != 1){
                $this->error('数据不合法');
            }
            $categoryParentId = $category->parent_id;
            $data['se_category_id'] = $id;
        }else{//0
            $categoryParentId = 0;
        }
        $sedcategorys = [];
        //获当前父类下的所有取子栏目
        $sedcategorys = model('Category')->getNormalCategoryByParentId($categoryParentId);

        $orders = [];
        //排序数据获取逻辑
        $order_sales = input('order_sales','');
        $order_price = input('order_price','');
        $order_time = input('order_time','');


        if (!empty($order_sales)){
            $orderflag = 'order_sales';
            $orders['order_sales'] = $order_sales;
        }elseif (!empty($order_price)){
            $orderflag = 'order_price';

            $orders['order_price'] = $order_price;
        }elseif (!empty($order_time)){
            $orderflag = 'order_time';

            $orders['order_time'] = $order_time;
        }else{
            $orderflag = '';
        }
        
        $data['city_id'] = $this->city->id;
        //跟据条件查询商品数据
        $deals = model('Deal')->getDealByConditions($data,$orders);

        return $this->fetch('',[
            'categorys'=>$categorys,
            'sedcategorys'=>$sedcategorys,
            'id'=>$id,
            'categoryParentId'=>$categoryParentId,
            'orderflag'=>$orderflag,
            'deals'=>$deals,
        ]);
    }
}