<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 22:00
 */
namespace app\common\model;

use think\Model;

class Order extends BaseModel
{
    protected $autoWriteTimestamp = true;//自动将当前时间戳写入数据库

    public function getNormalOrders($data=['status'=>1])
    {
        $order = ['id' => 'desc'];

        return $this->where($data)->order($order)->paginate();
    }
    
    
    
    public function add($data)
    {
        $data['status'] = 1;
        $this->save($data);
        return $this->id;
    }


    public function UpdataById($data,$out_trade_no)
    {
        $data['pay_status'] = 1;
        return $this->allowField(true)->save($data,['out_trade_no'=>$out_trade_no]);
    }
    
}