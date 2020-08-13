<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/11/2
 * Time: 13:23
 */
namespace app\index\controller;

use think\Controller;

class Map extends Controller
{
    public function getMapImage($data)
    {
        return \Map::staticImage($data);
    }
}