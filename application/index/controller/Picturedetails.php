<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

header('Access-Control-Allow-Origin: *');
class Picturedetails extends Controller
{
    public function index()
    {
        $routeid = $_POST['route_dy_id'];
        $re = Db::table('dy_route')
            ->where('route_dy_id',$routeid)
            ->where()
            ->field('route,thumb_route')
            ->select();
        $st = json_encode($re);
        echo $st;
    }

}