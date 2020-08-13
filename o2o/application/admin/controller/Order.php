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

class Order extends Controller
{
    private $model;//定义数据库model
    public function _initialize()
    {
        $this->model = model('Order');
    }
    
    public function index()
    {
        $orders = $this->model->getNormalOrders();

//        dump($orders);exit;
        return $this->fetch('', [
            'orders'=>$orders
        ]);
    }

    public function delorder()
    {
        $orders = $this->model->getNormalOrders($data=['status'=>2]);

//        dump($orders);exit;
        return $this->fetch('', [
            'orders'=>$orders
        ]);
    }

    /**
     * 修改状态
     */
    public function status()
    {
        $data = input('get.');
//        $validete = new validate();
//        if (!$validete->scene('status')->check($data)) {
//            $this->error($validete->getError());
//        }
        $res = $this->model->save(['status' => $data['status']], ['id' => $data['id']]);
//        print_r($data);
        if ($res) {
            $this->success('状态更新成功');
        } else {
            $this->error('状态更新失败');
        }
    }


}