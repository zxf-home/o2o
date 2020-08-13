<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function pagination($obj)
{
    if (!$obj){
        return '';
    }
    $params = request()->param();

    return '<div class="cl pd-5 bg-1 bk-gray mt-20 page-show">'.$obj->appends($params)->render().'</div>';
}



/**
 * @param $status
 * @return 显示的状态
 */
function status($status)
{
    if ($status == 1) {
        $str = "<span class='label label-success radius'>正常</span>";
    } elseif ($status == 0) {
        $str = "<span class='label label-danger radius'>待审</span>";

    } else {
        $str = "<span class='label label-danger radius'>删除</span>";
    }
    return $str;
}


function bisStatus($status)
{
    if ($status == 0) {
        $str = "<span class='label label-success radius'>待审</span>";
    } elseif ($status == 1) {
        $str = "<span class='label label-danger radius'>审核成功</span>";

    } else {
        $str = "<span class='label label-danger radius'>删除</span>";
    }
    return $str;
}

/**
 * @param $url
 * @param $type 0 :get 1:post
 * @param $data 数据
 */
function send_https_request($url, $data = null)
{
    $curl = curl_init(); //初始化curl，返回资源
    curl_setopt($curl, CURLOPT_URL, $url);//设置请求的服务器地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FAlSE);//verify peer不管是get、post，跳过证书的验证
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);//verify host不管是get、post，跳过证书的验证
    //验证是get还是post请求
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);//
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//return transfer
    $outopt = curl_exec($curl);//发出请求，接受返回参数
    curl_close($curl);
    return $outopt;
}

//提示函数
function show($status, $message = '', $data = [])
{
    return [
        'status' => intval($status),
        'message' => $message,
        'data' => $data,
    ];
}

function BisRegister($status)
{
    if ($status == 1) {
        $str = '商户入住成功';
    } elseif ($status == 0) {
        $str = '商户入住审核中，通过平台会发送邮件，请关注邮件';
    } elseif ($status == 2) {
        $str = '商户入住审核不通过,请重新提交材料';
    } else {
        $str = '该生请已被删除';
    }

    return $str;
}


function getSeCityName($path)
{
    if (empty($path)) {
        return '';
    }
    if (preg_match('/,/', $path)) {
        $cityPath = explode(',', $path);
        $cityId = $cityPath[1];
    } else {
        $cityId = $path;
    }

    $city = model('City')->get($cityId);

    return $city->name;
}


function countLocation($ids)
{
    if (!$ids) {
        return 1;
    }
    if (!preg_match("/,/",strval($ids))) {//strval($ids)
        return 1;
    }else{
        $data = explode(',',$ids );
        dump($data);
        return count($data);
    }
}

/**
 * 生成订单编号
 */
function setOrderSn()
{
    list($t1,$t2) = explode(' ', microtime());

//    dump($t1);exit();
    $t3 = explode('.',$t1*10000 );

    return $t2.$t3[0].(rand(10000,99999));
}

/**
 * @param $is_main
 * @return string
 * 是否是主店
 */
function isMain($is_main)
{
    if ($is_main == 1) {
        $str = "<span class='label label-success radius'>主店</span>";
    } else {
        $str = "<span class='label label-danger radius'>分店</span>";
    }
    return $str;
}

function payStatus($pay_status){
    if ($pay_status == 1) {
        $str = "<span class='label label-success radius'>已支付</span>";
    } else {
        $str = "<span class='label label-danger radius'>支付失败</span>";
    }
    return $str;
}
