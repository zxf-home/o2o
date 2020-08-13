<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 22:00
 */
namespace app\common\model;

use think\Model;

class BaseModel extends Model
{
    protected $autoWriteTimestamp = true;//自动将当前时间戳写入数据库
    public function add($data)
    {
        $data['status'] = 0;
//        $data['create_time'] = time();
        $this->save($data);
        return $this->id;
    }


    public function UpdataById($data,$id)
    {
        return $this->allowField(true)->save($data,['id'=>$id]);
    }
}