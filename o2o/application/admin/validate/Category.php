<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/19
 * Time: 21:04
 */
namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
    protected $rule = [
        ['name','require|max:10','分类名不能为空|分类名不能超过10'],
        ['parent_id','number'],
        ['id','number'],
        ['status','number|in:-1,0,1','状态必须数字|状态范围不合法'],
        ['listorder','number'],
        ['uname','alpha']
        
    ];


    protected $scene = [
        'add' => ['name','parent_id','id','uname'],//添加
        'listorder' => ['id','listorder'],//排序
        'status'   => ['id','status'],
    ];
}