<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 20:07
 */
namespace app\admin\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function welcome()
    {
//        return $this->fetch();
        return '欢迎进入管理页面';
    }
}