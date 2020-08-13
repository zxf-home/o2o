<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/25
 * Time: 18:52
 */
namespace app\bis\controller;

use think\Controller;

class Base extends Controller
{
    
    public $account;
    public function _initialize()
    {
       $res =  $this->isLogin();
        if (!$res){
            $this->redirect('login/index');
        }
        $sign = input('sign',0,'intval');
        $this->assign('sign',$sign);
    }

    public function isLogin()
    {
        $user = $this->getLoginUser();
        if ($user && $user->id){
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     * 获取登入用户
     */
    public function getLoginUser()
    {
        if (!$this->account){
            $this->account = session('bisAccount','','bis');
        }
        
        return $this->account;
    }
}
