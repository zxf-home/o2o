<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/11/2
 * Time: 12:09
 */
namespace app\index\controller;

class Detail extends Base
{
   public function index($id)
   {
       if (!intval($id)){
           $this->error('id不合法');
       }
       //跟据id查询商品数据
       $deal = model('Deal')->get($id);
       $bisId = $deal->bis_id;
       $bisData = model('Bis')->get($bisId);

       $this->assign('bisData',$bisData);
       if (!$deal || $deal->status !=1){
           $this->error('该商品不存在');
       }

      $category =  model('Category')->get($deal->category_id);

       $locations = model('BisLocation')->getNormalLocationsInId($deal->location_ids);

//       dump($locations);exit;

       $flag  = 0;

       if ($deal->start_time > time()){
           $flag = 1;
           $dtime = $deal->start_time - time();
           $timedata = ''   ;
           $d = floor($dtime/(3600/24));
           if ($d){
               $timedata .= $d.'天';
           }
           $h = floor($dtime%(3600/24)/3600);
           if ($h){
               $timedata .= $h.'小时';
           }
           $m = floor($dtime%(3600/24)%3600/60);
           if ($m){
               $timedata .= $m.'分';
           }
           $s = floor(floor($dtime%(3600/24)%3600%60));
           if($s){
               $timedata .= $s.'秒';
           }
           $this->assign('timedata',$timedata);
       }

       return $this->fetch('',[
           'title'=>$deal->name,
           'category'=>$category,
           'deal'=>$deal,
           'locations'=>$locations,
           'overplus'=>$deal->total_count - $deal->buy_count,
           'flag'=>$flag,
           'mapstr'=>$locations[0]['xpoint'].','.$locations[0]['ypoint']
       ]);
   }
}