<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/20
 * Time: 21:16
 */
namespace app\bis\controller;

use think\Controller;

class Index extends Base
{
    public function index()
    {
      return  $this->fetch();
    }
    public function welcome()
    {
//        return $this->fetch();
        return '欢迎进入管理页面';
    }
}