<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/20
 * Time: 21:16
 */
namespace app\bis\controller;
use think\Controller;

class Deal extends Base
{
    private $model ;//定义数据库model
    public function _initialize()
    {
        $this->model = model('Deal');
    }
    //商户中心 deal列表页面
    public function index()
    {
        $user = $this->getLoginUser();

        $data = [
            'bis_id'=>$user->bis_id,
            'status' => ['neq', -1],
        ];
        $order = [
            'listorder'=>'desc'
        ];
        $dealData = $this->model->where($data)->order($order)->select();
        
        return $this->fetch('',[
            'dealData' => $dealData,
        ]);
    }

    public function add()
    {
        $bisId = $this->getLoginUser()->bis_id;
//        $ews = model('BisLocation')->getNormalLocationByBisId($bisId);
//        print_r($ews);exit();/
//        dump($bisId);exit();

//        dump($bislocations);exit();
        if (request()->isPost()){
            $data = input('post.');

//            print_r($data['category_id']);exit();
            //校验数据volidete
            //todo

        $location = model('BisLocation')->get($data['location_ids'][0]);

//            dump($location);exit();

            $deals = [ 
                'bis_id'=>$bisId,
                'name'=>$data['name'],
                'image'=> $data['image'],
                'category_id'=>$data['category_id'],
                'se_category_id'=>empty($data['se_category_id'])?'':implode('|',$data['se_category_id'] ),
                'city_id'=>empty($data['se_city_id'])? $data['city_id']:$data['se_city_id'],
                'location_ids'=>empty($data['location_ids'])?'':$data['location_ids'],
                'start_time'=>strtotime($data['start_time']),//strtotime--将时间转换为时间戳形式
                'end_time'=>strtotime($data['end_time']),
                'total_count'=>$data['total_count'],
                'origin_price'=>$data['origin_price'],
                'current_price'=>$data['current_price'],
                'coupons_start_time'=>strtotime($data['coupons_begin_time']),
                'coupons_end_time'=>strtotime($data['coupons_end_time']),
                'notes'=>empty($data['notes'])? '':$data['notes'],
                'description'=>empty($data['description'])?'':$data['description'],
                'bis_account_id'=>$this->getLoginUser()->id,
                'xpoint'=>empty($location->xpoint) ? '':$location->xpoint,
                'ypoint'=>empty($location->ypoint) ? '':$location->ypoint
            ];


//            print_r($deals);exit();
          $id =  model('Deal')->add($deals);
            if ($id){
                $this->success('添加成功',url('deal/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $citys = model('City')->getNormalCitysByParentId();
            $category = model('Category')->getNormalCategoryByParentId();
//        print_r(json_decode(json_encode($citys)));exit();
            return $this->fetch('',[
                'citys'=>$citys,
                'categorys'=>$category,
                'bislocations'=> model('BisLocation')->getNormalLocationByBisId($bisId),
            ]);
        }
    }



    /**
     * 修改状态
     */
    public function status()
    {
        $data = input('get.');
        //数据验证
        //todo
//        $validete = new validate();
//        if (!$validete->scene('status')->check($data)) {
//            $this->error($validete->getError());
//        }
        $res = $this->model->save(['status'=>$data['status']],['id'=>$data['id']]);
        if ($res){
            $this->success('状态更新成功');
        }else{
            $this->error('状态更新失败');
        }
    }

}