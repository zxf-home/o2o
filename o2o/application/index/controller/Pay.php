<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/11/2
 * Time: 18:04
 */
namespace app\index\controller;
use think\log;
//支付控制器
class Pay extends Base{
    //发起电脑网站支付请求
    public function pagePay(){
        if (!$this->getLoginUser()){
            $this->error('请登入','user/login');
        }
        //查询数据order
        $orderId = input('get.id',0,'intval');
        if (empty($orderId)){
            $this->error('请求不合法');
        }
        $order = model('Order')->get($orderId);

        if (empty($order) || $order->status != 1 || $order->pay_status !=0){
            $this->error('无法进行该操作');
        }
        //判断定点是不是本人操作
        if($order->username != $this->getLoginUser()->username){
                $this->error('不是你的订单，支付错误');
        }
        $deal = model('Deal')->get($order->deal_id);
        //商户订单号，商户网站订单系统中唯一订单号，必填
//        $out_trade_no = trim($_POST['out_trade_no']);
        $out_trade_no = $order->out_trade_no;
        //订单名称，必填
//        $subject = trim($_POST['subject']);
        $subject = $deal->name;
        //付款金额，必填
//        $total_amount = trim($_POST['total_amount']);
        $total_amount = $order->total_price;
        //商品描述，可空
        //$body = trim($_POST['body']);
        //构造参数
        $payRequestBuilder = new \alipay\AlipayTradePagePayContentBuilder();
        // $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $aop = new \alipay\AlipayTradeService();
        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));
    }


    //回调地址
    public function notify_url(){
        $arr=$_POST;
        $alipaySevice = new \alipay\AlipayTradeService();
        $alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);
        /* 实际验证过程建议商户添加以下校验。
          1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
          2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
          3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
          4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
//请在这里加上商户的业务逻辑程序代
//——请根据您的业务逻辑来编写程序（以下代码仅作参考）
//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
//商户订单号
            $out_trade_no = $_POST['out_trade_no'];
//支付宝交易号
            $trade_no = $_POST['trade_no'];
//交易状态
            $trade_status = $_POST['trade_status'];
            if($_POST['trade_status'] == 'TRADE_FINISHED') {
//判断该笔订单是否在商户网站中已经做过处理
//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
//请务必判断请求时的total_amount与通知时获取的total_fee为一致的
//如果有做过处理，不执行商户的业务程序
//注意：
//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
//判断该笔订单是否在商户网站中已经做过处理
//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
//请务必判断请求时的total_amount与通知时获取的total_fee为一致的
//如果有做过处理，不执行商户的业务程序
//注意：
//付款完成后，支付宝系统发送该交易状态通知
            }
//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";//请不要修改或删除
        }else {
            //验证失败
            echo "fail";

        }
    }

    public function return_url()
    {
        $arr=$_GET;
        $alipaySevice = new \alipay\AlipayTradeService();
        $alipaySevice->writeLog(var_export($_GET,true));
        $result = $alipaySevice->check($arr);

        if($result) {
            //验证成功
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表商户订单号
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);
            $data = [
                'trade_no'=>$arr['trade_no'],
                'pay_time'=>$arr['timestamp'],
                'pay_status'=>1,
            ];
            $res = model('Order')->UpdataById($data,$out_trade_no);
            if (!$res){
                $this->error('支付错误');
            }
            echo "验证成功<br />支付宝交易号：".$trade_no;
            
            echo "<a href='http://101.200.120.154/o2o/public'>跳转首页</a>";
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        }
        else {
            //验证失败
            echo "验证失败";
        }
    }
}