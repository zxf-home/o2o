<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/25
 * Time: 19:44
 */
namespace app\bis\controller;

class Location extends Base
{

    private $model ;//定义数据库model
    public function _initialize()
    {
        $this->model = model('BisLocation');
    }
    /**
     * @return mixed
     *  门店列表
     */
    public function index()
    {
        $user = $this->getLoginUser();
        $data = [
            'bis_id'=>$user->bis_id,
             'status' => ['neq', -1],
        ];
        $order = [
          'is_main'=> 'desc',
            'listorder'=>'desc'
        ];
        
        $locationData = $this->model->where($data)->order($order)->select();
        return $this->fetch('',[
            'locationData' => $locationData,
        ]);
    }




    /**
     * @return mixed
     * 增加门店
     */
    public function add()
    {
        if (request()->isPost()){


            $data = input('post.');
            $bisId = $this->getLoginUser()->bis_id ;
            
            $data['cat'] = '';
            if (!empty($data['se_category_id'])){
                $data['cat'] = implode('|',$data['se_category_id'] );
            }

            //获取经纬度
            $lnglan = \Map::getLngLat($data['address']);

            if (!(empty($lnglan) || $lnglan->status == 1 || $lnglan->infocode == 1000)){
                $this->error('无法获取地址，请求错误');
            }
            $lnglan =  $lnglan->geocodes[0]->location;
//        print_r($lnglan);exit();
            $location = explode(',', $lnglan);
            $xpoint = empty($location[0]) ? '':$location[0];
            $ypoint = empty($location[1]) ? '':$location[1];
            
            //总店信息入库
            $locationData  = [
                'bis_id'=> $bisId,
                'name' => $data['name'],
                'logo' => $data['logo'],
                'tel' => $data['tel'],
                'address'=>$data['address'],
//                'bank_info'=>$data['bank_info'],
                'category_id'=>$data['category_id'],
                'category_path'=> $data['category_id'].','.$data['cat'],
                'city_id' => $data['city_id'],
                'city_path'=> empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
                'api_address' => $data['address'],
                'open_time'=>$data['open_time'],
//                'content' =>$data['content'],
                'is_main'=>0,//0代表分店信息
                'xpoint' =>$xpoint,
                'ypoint'=>$ypoint
            ];
            $location = model('BisLocation')->add($locationData);
            if ($location){
                return $this->success('门店申请成功');
            }else{
                return $this->error('门店申请失败');
            }
        }

        $citys = model('City')->getNormalCitysByParentId();
        $category = model('Category')->getNormalCategoryByParentId();
//        print_r(json_decode(json_encode($citys)));exit();
        return $this->fetch('',[
            'citys'=>$citys,
            'categorys'=>$category
        ]);
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