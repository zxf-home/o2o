<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/20
 * Time: 21:14
 */
namespace app\bis\controller;

use think\Controller;

class Login extends Controller
{
    public function index()
    {
        if (request()->isPost())
        {
            $data = input('post.');
            //校验数据正确性
            $ret  = model('BisAccount')->get(['username'=>$data['username']]);

//            dump($ret);exit();
            if (!$ret || $ret->status != 1){
                $this->error('该用户不存在或用户审核未通过，请重新输入');
            }
            if ($ret->password != md5($data['password'].$ret->code)){
                $this->error('密码不正确');
            }
            model('BisAccount')->updateById(['last_login_time'=>time()],$ret->id);

            //保存用户信息Session；
            session('bisAccount',$ret,'bis');
            $this->success('登陆成功',url('index/index',['bis_id'=>$ret->bis_id]));
        }else{
            $account = session('bisAccount','','bis');

            if ($account && $account->id){
                $this->redirect(url('index/index'));
            }
            return $this->fetch();
        }
    }



    public function logout()
    {
        session(null,'bis');
        //跳转页面
        $this->redirect(url('login/index'));
    }
    
}