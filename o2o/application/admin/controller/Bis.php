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

class Bis extends Controller
{
    private $model ;//定义数据库model
    public function _initialize()
    {
        $this->model = model('Bis');
    }

    public function index()
    {
        $bis = $this->model->getBisByStatus(1);

//        dump($bis);exit();
//        dump($this->model->where( ['status' => 0])->order(['id'=>'desc'])->select());exit();
        return $this->fetch('',['bis'=>$bis]);
    }

    /*入住申请*/
    public function apply()
    {
        $bis = $this->model->getBisByStatus();

//        dump($bis);exit();
//        dump($this->model->where( ['status' => 0])->order(['id'=>'desc'])->select());exit();
        return $this->fetch('',['bis'=>$bis]);
    }


    public function detail()
    {
        $id = input('get.id');
        $citys = model('City')->getNormalCitysByParentId();
        $category = model('Category')->getNormalCategoryByParentId();
//        print_r(json_decode(json_encode($citys)));exit();



        $bisData = model('Bis')->get($id);

        $LocationData = model('BisLocation')->get(['bis_id'=>$id,'is_main'=>1]);

//        dump($LocationData);exit();
        $accountData = model('BisAccount')->get(['bis_id'=>$id,'is_main'=>1]);


//        dump($accountData);exit();
        return $this->fetch('',[
            'citys'=>$citys,
            'categorys'=>$category,
            'bisData'=>$bisData,
            'LocationData'=>$LocationData,
            'accountData'=>$accountData
        ]);
    }

    /*入住申请*/
    public function dellist()
    {
        $bis = $this->model->getBisByStatus(-1);

//        dump($bis);exit();
//        dump($this->model->where( ['status' => 0])->order(['id'=>'desc'])->select());exit();
        return $this->fetch('',['bis'=>$bis]);
    }




    /**
     * 修改状态
     */
    public function status()
    {
        $data = input('get.');

        //数据验证id s
//        todo
//        $validete = new validate('Bis');
//        if (!$validete->scene('status')->check($data)) {
//            $this->error($validete->getError());
//        }

//        $accountData = model('BisAccount')->get(['bis_id'=>$data['id'],'is_main'=>1]);

//        dump($accountData);exit();
        $res = $this->model->save(['status'=>$data['status']],['id'=>$data['id']]);

        $location = model('BisLocation')->save(['status'=>$data['status']],['bis_id'=>$data['id'],'is_main'=>1]);
//        print_r($data);
        $account = model('BisAccount')->save(['status'=>$data['status']],['bis_id'=>$data['id'],'is_main'=>1]);


        if ($res && $location && $account){
            //成功发送邮件
            $this->success('状态更新成功');
        }else{
            $this->error('状态更新失败');
        }
    }
}