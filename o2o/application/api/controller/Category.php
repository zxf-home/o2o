<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/20
 * Time: 23:11
 */
namespace app\api\controller;

use think\Controller;

class Category extends Controller
{
    private $model;
    public function _initialize()
    {
        $this->model = model('Category');
    }
    public function getCategoryByParentId($id)
    {
        if (!intval($id)){
            $this->error('ID不合法');
        }
        //通过id获取二级城市
        $categorys = $this->model->getNormalCategoryByParentId($id);

        if (!$categorys){
            $this->result($categorys,0,'fail');
        }else{
            $this->result($categorys,1,'success');
        }

    }
}