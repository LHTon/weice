<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

header('Access-Control-Allow-Origin: *');
class Picturedetails extends Controller
{
    //图集的详情页面
    public function index()
    {
        $routeid = $_GET['route_dy_id'];
        $re = Db::table('dy_route')
            ->where('route_dy_id',$routeid)
            ->field('route,thumb_route')
            ->select();


        foreach ($re as $key) {
            $arr['route'][] = $key['route'];
            $arr['thumb_route'][] = $key['thumb_route'];
        }
        $cs = json_encode($arr);
        echo $cs;


    }

}