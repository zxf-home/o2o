<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/20
 * Time: 21:47
 */
namespace app\common\model;

use think\Model;

class City extends Model
{

    protected $autoWriteTimestamp = true;//自动将当前时间戳写入数据库

    public function add($data)
    {
        $data['status'] = 1;
//        $data['create_time'] = time();
        return $this->save($data);
    }

    /**
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNormalFristCity()
    {
        //条件
        $data = [
            'status' => 1,
            'parent_id' => 0,
        ];
        //条件
        $order = [

            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();
    }

    /**
     * 获取一级分类
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getFristCity($parent_id = 0)
    {
        $data = [
            'parent_id' => $parent_id,
            'status' => ['neq', -1],
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        $res = $this->where($data)->order($order)->paginate();
//        echo $this->getLastSql();
//        echo "<pre>";
        return $res;
    }


    /**
     * 商家注册选城市方法
     * @param int $parentId
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNormalCitysByParentId($parentId = 0)
    {
        $data = [
            'status' => 1,
            'parent_id' => $parentId
        ];
        $order = [
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();
    }


    public function getNormalCitys()
    {
        $data = [
            'status'=>1,
//            'parent_id'=>['eq',0]
        ];

        $order = ['id'=>'desc'];

        return $this->where($data)->order($order)->select();
    }





}