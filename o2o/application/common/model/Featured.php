<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 22:00
 */
namespace app\common\model;

use think\Model;

class Featured extends BaseModel
{

    /**
     * 跟据类型获取列白数
     */
    public function getFeaturedsByTypes($type)
    {
        $data = [
            'type' =>$type,
            'status'=>['neq' , -1]
        ];
        $order = ['id'=>'desc'];

        $result = $this->where($data)->order($order)->paginate();

//        echo $this->getLastSql();exit;
        return $result;
    }

    public function getIndexImages()
    {
        $data = [
            'type' => 0,
            'status'=>1
        ];
        $order = ['id'=>'desc'];

     return  $this->where($data)->order($order)->select();
    }
}