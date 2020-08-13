<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/11/2
 * Time: 16:31
 */
namespace app\index\controller;

use Think\Exception;

class Order extends Base
{

    public function index()
    {
        $user =$this->getLoginUser();
        if (!$user){
            $this->error('请登入','user/login');
        }
        $id = input('id',0,'intval');

        if (!$id){
            $this->error('参数不合法');
        }

//        id=7&deal_count7&total_price=84
        $dealCount = input('deal_count',0,'intval');
        $totalPrice = input('total_price');



        $deal = model('Deal')->find();

//        dump($deal);exit();
        if (!$deal || $deal->status !=1){
            $this->error('上品不存在');
        }

        if (empty($_SERVER['HTTP_REFERER'])){
            $this->error('请求不合法');
        }

        $orderSn = setOrderSn();
        //数据入库
        $data =[
            'out_trade_no'=>$orderSn,
            'user_id'=> $user->id,
            'username'=>$user->username,
            'deal_id'=>$id,
            'deal_count'=>empty($dealCount)? 1:$dealCount,
            'total_price'=>$totalPrice
        ];

       
        try{
            $orderId = model('Order')->add($data);

        }catch (\Exception $e){
            $this->error('订单处理失败');
        }

        $this->redirect(url('pay/pagePay',['id'=>$orderId]));
    }

    public function confirm()
    {
        
        if (!$this->getLoginUser()){
            $this->error('请登入','user/login');
        }

        //
        $id = input('id',0,'intval');
        if (!$id){
            $this->error('参数不合法');
        }

        $count = input('get.count',1,'intval');
        $deal = model('Deal')->find($id);
        if (!$deal || $deal->status !=1){
            $this->error('上品不存在');
        }
        $deal = $deal->toArray();


       return $this->fetch('',[
           'controller'=>'order',
           'count'=>$count,
           'deal'=>$deal
       ]);
    }


    public function orderLists()
    {
        if (!$this->getLoginUser()){
            $this->error('请登入','user/login');
        }
        $id = input('id','','intval');

        if (!$id){
            $this->error('参数不合法');
        }

        $orderlistData = model('Order')->where(['user_id'=>$id,'status'=>1])->paginate(10);



        $dealArr[] = [];

        $count = 0;
        foreach ($orderlistData as $value){
            $data =  model('Deal')->get($value->deal_id);
            $dealArr[$count]['name'] = empty($data['name']) ?  '':$data['name'];
            $dealArr[$count]['image'] = empty($data['image']) ? '':$data['image'];
            $dealArr[$count]['current_price'] = empty($data['current_price'])?'':$data['current_price'];
            $dealArr[$count]['total_price'] = $value->total_price;
            $dealArr[$count]['deal_count'] = $value->deal_count;
            $dealArr[$count]['pay_status'] = $value->pay_status;
            $dealArr[$count]['id'] = $value->id;
            $count++;
        }


        return $this->fetch('',[
            'dealArr'=>$dealArr,
            'orderlistData'=>$orderlistData,
            'title'=>'我的订单'
        ]);
    }

    public function delOrder()
    {
        $id = input('get.id',0,'intval');
        if (!$id){
            $this->error('参数不合法');
        }

        $res = model('Order')->where(['id'=>$id])->update(['status'=>2]);

        if (!$res){
            $this->error('删除失败');
        }else{
            $this->success('删除成功');
        }
    }
}