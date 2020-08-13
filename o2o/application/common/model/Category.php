<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 22:00
 */
namespace app\common\model;

use think\Model;

class Category extends Model
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
    public function getNormalFristCategory()
    {
        //条件
        $data = [
            'status' => 1,
            'parent_id'=>0,
        ];
        //条件
        $order = [

            'id'  => 'desc',
        ];
        return $this->where($data)->order($order)->select();
    }

    /**
     * 获取一级分类
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getFristCategory($parent_id = 0)
    {
        $data = [
            'parent_id'=> $parent_id,
            'status' => ['neq',-1],
        ];
        $order = [
            'listorder' =>'desc',
            'id'  => 'desc',
        ];
        $res = $this->where($data)->order($order)->paginate();
//        echo $this->getLastSql();
//        echo "<pre>";
        return $res;
    }

    public function getNormalCategoryByParentId($parentId=0){
        $data = [
            'status' => 1,
            'parent_id'=>$parentId
        ];
        $order = [
            'id'=>'desc'
        ];
        return $this->where($data)->order($order)->select();
    }

    public function getNormalRecommendCategoryByParentId($id=0,$limit=5)
    {
        $data = [
            'parent_id'=>$id,
            'status'=>1
        ];
        $order = [
            'listorder' => 'desc',
            'id'=> 'desc'
        ];
        $result = $this->where($data)->order($order);

        if ($limit){
            $result = $result->limit($limit);
        }

        return $result->select();
    }

    public function getNormalCategoryIdParentId($ids)
    {
        $data = [
            'parent_id'=>['in',implode(',',$ids )],
            'status'=>1
        ];
        $order = [
            'listorder' => 'desc',
            'id'=> 'desc'
        ];
        $result = $this->where($data)->order($order)->select();

        return $result;

    }
}