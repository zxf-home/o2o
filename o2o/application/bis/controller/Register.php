<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/20
 * Time: 21:14
 */

namespace app\bis\controller;
use phpmailer\Email as email;
use think\Controller;
use think\Validate;

class Register extends Controller
{
    public function index()
    {
        $citys = model('City')->getNormalCitysByParentId();
        $category = model('Category')->getNormalCategoryByParentId();
//        print_r(json_decode(json_encode($citys)));exit();
        return $this->fetch('',[
            'citys'=>$citys,
            'categorys'=>$category
        ]);
    }
    
    public function add()
    {
        header('Content-Type:text/html;charset=utf8');
        if (!request()->isPost()){
            $this->error('请求错误');
        }
        $data = input('post.');

        $validate = validate('Bis');
        if (!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }


        $lnglan = \Map::getLngLat($data['address']);

        if (!(empty($lnglan) || $lnglan->status == 1 || $lnglan->infocode == 1000)){
            $this->error('无法获取地址，请求错误');
        }




        //获取经纬度
        $lnglan =  $lnglan->geocodes[0]->location;
//        print_r($lnglan);exit();
        $location = explode(',', $lnglan);
        $xpoint = empty($location[0]) ? '':$location[0];
        $ypoint = empty($location[1]) ? '':$location[1];
        $findres = model('BisAccount')->get(['username'=>$data['username']]);
        if ($findres){
            $this->error('用户已存在，请从新分配');
        }
        //商户信息入库
        $accountData = [
            'name' => $data['name'],
            'city_id' => $data['city_id'],
            'city_path'=> empty($data['se_city_id'])?$data['city_id']:$data['city_id'].",".$data['se_city_id'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'description' => empty($data['description']) ? $data['description'] = '':$data['description'] ,
            'bank_info'=>$data['bank_info'],
            'bank_user' => $data['bank_user'],
            'bank_name' => $data['bank_name'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel'],
            'email' => $data['email']
        ];
        $bisId = model('Bis')->add($accountData);
        //总店相关信息检验

        $data['cat'] = '';
        if (!empty($data['se_category_id'])){
            $data['cat'] = implode('|',$data['se_category_id'] );
        }
        //总店信息入库
        $locationData  = [
            'bis_id'=> $bisId,
            'name' => $data['name'],
            'logo' => $data['logo'],
            'bank_info'=>$data['bank_info'],
            'address'=>$data['address'],
            'tel' => $data['tel'],
            'contact'=>$data['contact'],
            'category_id'=>$data['category_id'],
            'category_path'=> $data['category_id'].','.$data['cat'],
            'city_id' => $data['city_id'],
            'city_path'=> empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
            'api_address' => $data['address'],
            'open_time'=>$data['open_time'],
            'content' =>$data['content'],
            'is_main'=>1,
            'xpoint' =>$xpoint,
            'ypoint'=>$ypoint
        ];
        $locationId = model('BisLocation')->add($locationData);
        $data['code'] = mt_rand(100,10000);
        //账户相关信息检验


        $accountData = [
            'bis_id'=>$bisId,
            'username'=>$data['username'],
            'code'=>$data['code'],
            'password'=>md5($data['password'].$data['code']),
            'is_main' => 1,//代表总管理员
        ];
       $accountId =  model('BisAccount')->add($accountData);
        if (!$accountId){
            $this->error('申请失败');
        }
        //成功发送邮件给用户
        $eamil = new email();
        $url = request()->domain().url('bis/register/waiting',['id'=>$bisId]);
        $title = 'o2o入驻申请通知';
        $content = '你提交的入驻申请需要平台审核 <a herf="'.$url.' " target="_blank" >'.$url.'</a> 查看审核状态';
        $eamil->send_email($data['email'],$title ,$content );
        $this->success('申请成功',url('register/waiting',['id'=>$bisId]));
    }

    public function waiting($id){
        if (!$id){
            $this->error('error');
        }
        $userdetail = model('Bis')->get($id);

        return $this->fetch('',['userdetail'=>$userdetail]);
    }

    
}


