<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 22:00
 */
namespace app\common\model;

use think\Model;

class Deal extends BaseModel
{


    public function getNormalDeals($data = [])
    {
        $data['status'] = 1;
        $order = ['id' => 'desc'];

        return $this->where($data)->order($order)->paginate();
    }


    /**
     *  跟据分类 以及城市获取 商品数据
     * @param $id  分类id
     * @param $cityId  成市
     * @param $limit  条数
     */
    public function getNormalDealByCategoryCityId($id, $cityId, $limit = 10)
    {
        $data = [
            'end_time' => ['gt', time()],
            'category_id' => $id,
            'city_id' => $cityId,
            'status' => 1
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        $result = $this->where($data)->order($order);

        if ($limit) {
            $result = $result->limit($limit);
        }
        return $result->select();
    }


    public function getDealByConditions($data = [], $orders)
    {
        if (!empty($orders['order_sales'])) {
            $order['buy_count'] = 'desc';
        }
        if (!empty($orders['order_price'])) {
            $order['current_price'] = 'desc';
        }
        if (!empty($orders['order_time'])) {
            $order['create_time'] = 'desc';
        }
        $order['id']='desc';

        $datas[] = "end_time >".time();

        if (!empty($data['se_category_id'])){
            $datas[]= 'find_in_set('.$data['se_category_id'].',se_category_id)';
        }
        
        if (!empty($data['category_id'])){
            $datas[] = 'category_id = '.$data['category_id'];
        }

        if (!empty($data['city_id'])){
            $datas[] = 'city_id = '.$data['city_id'];
        }

        $datas[] = 'status = 1';



        $result =$this->where(implode(' and ',$datas ))->order($order)->paginate(10);

//        echo $this->getLastSql();exit();
        return $result;

    }
}