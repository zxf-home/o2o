<?php
namespace app\index\controller;
use think\Controller;

class User extends Controller
{
    public function login()
    {
        //获取session判断用户是否登入
        $user = session('o2o_user','','o2o');
        if ($user && $user->id){
            $this->redirect('index/index');
        }
        
        return $this->fetch();
        
    }

    public function loginCheck()
    {
        if (!request()->isPost()){
            $this->error('提交不合法');
        }
        $data = input('post.');
        //数据验证
        try{
            $user = model('User')->getUserByUsername($data['username']);
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }
        if (!$user || $user->status != 1){
            $this->error('当前用户不存在或不合法');
        }
        //密码是否正确
        if (md5($data['password'].$user->code) != $user->password){
          
            $this->error('密码错误');
        }

        $res = model('User')->UpdataById(['last_login_time' => time()],$user->id);
        if (!$res){
            $this->error('登入失败');
        }
        session('o2o_user',$user,'o2o');
        $this->success('登陆成功',url('index/index'));
    }
    


    public function logout()
    {
        session(null,'o2o');
        $this->redirect('user/login');
    }


    public function register()
    {
        if (request()->isPost()){
            $data = input('post.');
            //数据验证

            if (!captcha_check($data['verifyCode'])){
                return $this->error('验证码错误');
            }
            if ($data['password'] != $data['repassword']){
                return $this->error('两次密码输入不相同');
            }
            //生成随机数
            $data['code'] = mt_rand(100,10000);
            $data['password'] = md5($data['password'].$data['code']);

            $res = '';
            try{
               $res =  model('User')->add($data);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            if ($res){
                $this->success('注册成功',url('user/login'));
                }else{
                  $this->error('注册失败');
            }
        }else{
            return $this->fetch();
        }
    }
}
