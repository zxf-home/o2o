<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 22:00
 */
namespace app\common\model;

use think\Model;

class Bis extends BaseModel
{
    /**
     * @param $status
     * 通过状态获取用户数据
     */
    public function getBisByStatus($status=0)
    {
        $data =[
            'status' => $status
        ];
        $order = [
            'id' => 'desc'
        ];
         return $this->where($data)->order($order)->paginate();
    }

}