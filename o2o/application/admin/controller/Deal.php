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

class Deal extends Controller
{
    private $model;//定义数据库model

    public function _initialize()
    {
        $this->model = model('Deal');
    }

    public function index()
    {
        $data = input('get.');
        $sdata = [];
        if (!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time']) > strtotime($data['start_time'])) {
            $sdata['create_time'] = [
                ['gt', strtotime($data['start_time'])],
                ['lt', strtotime($data['end_time'])],
            ];
        }
        if (!empty($date['category_id'])) {
            $sdata['category_id'] = $data['category_id'];
        }
        if (!empty($data['city_id'])) {
            $sdata['city_id'] = $data['city_id'];
        }

        if (!empty($data['name'])) {
            $sdata['name'] = ['like', '%' . $data['name'] . '%'];
        }

        $deals = $this->model->getNormalDeals($sdata);

        $categorys = model('Category')->getNormalCategoryByParentId();

        $categoryArrs = $cityArrs = [];
        foreach ($categorys as $category) {
            $categoryArrs[$category->id] = $category->name;
        }
        $citys = model('City')->getNormalCitys();
        foreach ($citys as $city) {
            $cityArrs[$city->id] = $city->name;
        }

//        dump(json_decode(json_encode($citys)));exit();

//        print_r($citys);exit();
        return $this->fetch('', [
            'categorys' => $categorys,
            'citys' => $citys,
            'deals' => $deals,
            'category_id' => empty($data['category_id']) ? '' : $data['category_id'],
            'name' => empty($data['name']) ? '' : $data['name'],
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'city_id' => empty($data['city_id']) ? '' : $data['city_id'],
            'categoryArrs' => $categoryArrs,
            'cityArrs' => $cityArrs
        ]);
    }


    public function edit()
    {
        $id = input('get.id');
        //一级城市
        $dealData = model('Deal')->get($id);

        $seCity = model('City')->get($dealData->city_id);
        $parentCity = model('City')->get($seCity->parent_id);

        $category = model('Category')->get($dealData->category_id);
        $seCategory = model('Category')->get($dealData->se_category_id);

        $bislocations = model('BisLocation')->get(['bis_id' => $id, 'is_main' => 1]);

        $accountData = model('BisAccount')->get(['bis_id' => $id, 'is_main' => 1]);

        return $this->fetch('', [
            'category' => $category,
            'seCategory' => $seCategory,
            'parentCity' => $parentCity,
            'dealData' => $dealData,
            'bislocations' => $bislocations,
            'accountData' => $accountData
        ]);
    }

    public function detail()
    {
        $deals = $this->model->where(['status'=>0])->paginate();

//        dump($deals);exit;
        return $this->fetch('',[
            'deals'=>$deals
        ]);
    }

    /**
     * 修改状态
     */
    public function status()
    {
        $data = input('get.');
//        $validete = new validate();
//        if (!$validete->scene('status')->check($data)) {
//            $this->error($validete->getError());
//        }
        $res = $this->model->save(['status' => $data['status']], ['id' => $data['id']]);
//        print_r($data);
        if ($res) {
            $this->success('状态更新成功');
        } else {
            $this->error('状态更新失败');
        }
    }


}