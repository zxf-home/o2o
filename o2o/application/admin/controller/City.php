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

class City extends Controller
{
    private $model ;//定义数据库model
    public function _initialize()
    {
        $this->model = model('City');
    }

    public function index()
    {
        $parent_id = input('get.parent_id',0,'intval');

        $category =$this->model->getFristCity($parent_id);
        return $this->fetch('',[
            'categorys' => $category,
        ]);
    }

    public function add()
    {
        $category = $this->model->getNormalFristCity();
        return $this->fetch('', [
            'categorys' => $category,
        ]);

    }

    /**
     * 写入数据库
     */
    public function save()
    {
        /*判断请求方式*/
        if (!request()->isPost()){
            $this->error('请求失败');
        }

        $data = input('post.');
        $validete = new validate();
        if (!$validete->scene('add')->check($data)) {
            $this->error($validete->getError());
        }

        if(!empty($data['id'])){
            $this->update($data);
        }

        //将数据写入数据库（model）
        $res = $this->model->add($data);
        if ($res) {
            $this->success('插入成功');
        } else {
            $this->error('插入失败');
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function edit($id =0)
    {
        if (intval($id<1)){
            $this->error('参数不合法');
        }
        $data = $this->model->get($id);
        $category = $this->model->getNormalFristCity();
        return $this->fetch('', [
            'categorys' => $category,
            'data'      => $data,
        ]);
    }


    public function update($data)
    {
        $res = $this->model->save($data,['id'=>intval($data['id'])]);
        if ($res){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }

    public function listorder($id,$listorder)
    {
        $res = $this->model->save(['listorder'=>$listorder],['id'=>$id]);

        if ($res){
            $this->result($_SERVER['HTTP_REFERER'],1,'success');
        }else{
            $this->result($_SERVER['HTTP_REFERER'],0,'fail');
        }
    }

    /**
     * 修改状态
     */
    public function status()
    {
        $data = input('get.');
        $validete = new validate();
        if (!$validete->scene('status')->check($data)) {
            $this->error($validete->getError());
        }
        $res = $this->model->save(['status'=>$data['status']],['id'=>$data['id']]);
//        print_r($data);
        if ($res){
            $this->success('状态更新成功');
        }else{
            $this->error('状态更新失败');
        }
    }
}