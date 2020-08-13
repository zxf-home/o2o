<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/23
 * Time: 14:44
 */

return [
    //跟据地理位置获取经纬度
    'key' => '7fe857619bb536bed351ba4d3c0f6a46',
    'gaode_map_url' => 'https://restapi.amap.com',
    'geocode'  =>'/v3/geocode/geo',

    //跟据经纬度获取静态地图
    'staticmap' => '/v3/staticmap',
    'size'    => '400*300',
    'markers'       => 'mid,,A:',
];