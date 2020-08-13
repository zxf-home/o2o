<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/20
 * Time: 23:11
 */
namespace app\api\controller;

use think\Controller;

class City extends Controller
{
    private $model;
    public function _initialize()
    {
        $this->model = model('City');
    }
    public function getCityByParentId()
    {
        $id = input('post.id');
        if (!$id){
            $this->error('ID不合法');
        }
        //通过id获取二级城市
        $citys = $this->model->getNormalCitysByParentId($id);

        if (!$citys){
            $this->result($citys,0,'fail');
        }else{
            $this->result($citys,1,'success');
        }

    }
}