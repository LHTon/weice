<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

header('Access-Control-Allow-Origin: *');

class Index extends Controller
{
    public function index()
    {

//        $openid = $_POST['openid'];
//        $result = Db::query(
//            "select describes, route_dy_id, thumb_route, dy_route.create_time
//            from dy_dynamic left join dy_route
//            on dy_dynamic.idx_dynamic = dy_route.route_dy_id
//            where openid = $openid and dy_dynamic.idx_dynamic = dy_route.route_dy_id
//			GROUP BY route_dy_id"
//        );
//        echo json_encode($result);
        $re0 = Db::view('User','nickname,headimgurl')
            ->view('Dynamic','describes','Dynamic.openid = User.openid','LEFT')
            ->view('Route','route_dy_id,thumb_route,create_time','Dynamic.idx_dynamic = Route.route_dy_id','RIGHT')
            ->where('Dynamic.idx_dynamic = Route.route_dy_id')
            ->select();

        $re = Db::view('User','nickname,headimgurl')
            ->view('Dynamic','describes','Dynamic.openid = User.openid','LEFT')
            ->view('Route','route_dy_id,thumb_route,create_time','Dynamic.idx_dynamic = Route.route_dy_id','RIGHT')
            ->where('Dynamic.idx_dynamic = Route.route_dy_id')
            ->select();

        $re1 = Db::view('User','nickname,headimgurl')
            ->view('Dynamic','describes','Dynamic.openid = User.openid','LEFT')
            ->view('Route','route_dy_id,thumb_route,create_time','Dynamic.idx_dynamic = Route.route_dy_id','RIGHT')
            ->where('Dynamic.idx_dynamic = Route.route_dy_id')
            ->group('Route.route_dy_id')
            ->select();

        foreach ($re1 as $key){
//            echo $key['route_dy_id'].'<br>';
            $arr[] = $key['route_dy_id'];
        }
//        dump($arr);
        foreach ($re as $key=>$value){
//            echo count($arr);
            for($i=0;$i<count($arr);$i++){
                if($value['route_dy_id'] == $arr[$i]){
                    $newarr[$value['route_dy_id']][] =  $value['thumb_route'];
                }
            }
        }
        $re = json_encode($newarr);
        echo $re;
    }
}
