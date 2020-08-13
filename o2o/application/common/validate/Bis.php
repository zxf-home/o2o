<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/23
 * Time: 10:45
 */
namespace app\common\validate;

use think\Validate;

class Bis extends Validate
{


    protected $rule = [
        ['name','require|max:25','分类名不能为空|分类名不能超过10'],
        ['email','email'],
        ['logo','require'],
        ['city_id','require'],
        ['bank_info','require'],
        ['bank_name','require'],
        ['bank_user','require'],
        ['faren','require'],
        ['faren_tel','require|/^1[3-8]{1}[0-9]{9}$/']
    ];

    protected $sence = [
        'add' => ['name','email','logo','city_id','bank_info','bank_name','bank_user','faren','faren_tel'],//添加
    ];
}