<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 20:07
 */
namespace app\admin\controller;

use think\Controller;

use app\admin\validate\Category as validate;

class Featured extends Base
{
    private $model;//定义数据库model

    public function _initialize()
    {
        $this->model = model('Featured');
    }

    public function index()
    {
        $types = config('featured.featured_type');

        
        //获取列表数据
        $type = input('get.type',0,'intval');
        
        $results = $this->model->getFeaturedsByTypes($type);
        
        return $this->fetch('',[
            'types'=>$types,
            'results'=>$results
        ]);
    }

    public function add()
    {

        if (request()->isPost()){
             $data = input('post.');

            //数据要做严格校验
            //todo

           $id =  model('featured')->add($data);
            if($id){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }

        }else{
            //获取推荐为类别

            $types = config('featured.featured_type');

            return $this->fetch('',[
                'types' =>$types
            ]);
        }
    }

}