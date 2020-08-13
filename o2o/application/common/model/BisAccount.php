<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 22:00
 */
namespace app\common\model;

use think\Model;

class BisAccount extends BaseModel
{
    public function updateById($data,$id)
    {
        //allowField过滤非数据表字段
        return $this->allowField(true)->save($data,['id'=>$id]);
    }
}