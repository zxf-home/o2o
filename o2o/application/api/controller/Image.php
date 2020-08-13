<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/10/21
 * Time: 22:14
 */
namespace app\api\controller;

use think\Controller;
use think\Request;
use think\File;
class Image extends Controller
{
    /**
     * 处理图片上传
     */
    public function upload()
    {
        $root = request()->domain().'/o2o/public';

       $file =  Request::instance()->file('file');

        $info = $file->move('upload');


        if ($info && $info->getPathname()){
            return show(1,'success',$root.'/'.$info->getPathname());

        }else{
            return show(0,'upload error');
        }
    }
}