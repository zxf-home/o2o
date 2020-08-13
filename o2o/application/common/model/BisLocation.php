<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 22:00
 */
namespace app\common\model;

use think\Model;

class BisLocation extends BaseModel
{
    public function getNormalLocationByBisId($bisId)
    {
        $data = [
            'bis_id'=>$bisId,
            'status'=>1
        ];
        $result = $this->where($data)->order('id','desc')->select();
        return $result;
    }

    /**
     * 获取分店方法---->location_ids
     */
    public function getNormalLocationsInId($location_ids)
    {
        $data = [
            'id'=>['in',$location_ids],
             'status'=>1,
        ];

        return $this->where($data)->select();
    }
}