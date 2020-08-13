<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/11/2
 * Time: 9:32
 */
namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    /**
     * 状态更新
     */
    public function status()
    {
        //获取数据
        $data = input('get.');
        //数据校验
        //todo

        if (empty($data['id'])){
            $this->error('id不合法');
        }
        if (!is_numeric($data['status'])){
            $this->error('status不合法');
        }

        //获取控制器
        $model = request()->controller();
        $res = model($model)->save(['status'=>$data['status']],['id'=>$data['id']]);
        if ($res){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }


    /**
     * @param $id
     * @param $listorder 排序
     */
    public function listorder($id,$listorder)
    {
        //获取控制器
        $model = request()->controller();
        $res = model($model)->save(['listorder'=>$listorder],['id'=>$id]);
        if ($res){
            $this->result($_SERVER['HTTP_REFERER'],1,'success');
        }else{
            $this->result($_SERVER['HTTP_REFERER'],0,'fail');
        }
    }
}