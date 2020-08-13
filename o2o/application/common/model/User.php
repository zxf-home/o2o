<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/11/2
 * Time: 9:52
 */
namespace app\common\model;

use think\Model;

class User extends BaseModel
{

    public function getNormalUser($data=['status'=>['neq',2]])
    {
        return $this->where($data)->select();
    }

    public function add($data =[])
    {
        //如果提交的数据不是数组
        if (!is_array($data)){
            exception('传递的数据不是数组');
        }
        $data['status'] = 1;
        return  $this->data($data)->allowField(true)->save();
    }
    /**
     * 跟据用户名获取用户信息
     * @param $username
     */
    public function getUserByUsername($username)
    {
        if (!$username){
            exception('用户名不合法');
        }
        $data = ['username'=>$username];
        return $this->where($data)->find();
        
    }

}
