<?php
/**
 * Created by PhpStorm.
 * User: 加油鸭
 * Date: 2019/6/4
 * Time: 20:04
 */

namespace app\index\controller;


use app\index\model\Dynamic;
use app\index\model\Fans;
use app\index\model\Tabs;
use app\index\model\User;
use app\index\model\Route;
use think\Controller;

class Video extends Controller
{
    /*
     * @return josn
     * @poster 缩略图
     * @url 视频路径
     */
    public function index()
    {
        //获取用户ID
        $openid = action('index/Message/openid');
        $video = $this->video($openid);
        $video = json_encode($video);
        return $video;
    }

    //遍历视频
    public function video($value)
    {
        //获取用户ID
        $openid = $value;
//        halt($openid);
        $UserModel = new User();
        $RouteModel = new Route();
        $DymanicModel = new Dynamic();
        $TabsModel = new Tabs();
        //获取资源ID
        $dymanic = $UserModel->dynamic()->where([
            'openid' => $openid['openid'],
            'type' => '1'
        ])->column('idx_dynamic');
//        print_r($dymanic);

        /*
         * rreturn:返回flase是代表无视频：请添加视频
         */
        if (empty($dymanic) ) {
            return "请添加视频";
        }

        //获取视频资源ID
            foreach ( $dymanic as $k => $v) {
                $data[] = $RouteModel->where('route_dy_id' ,$v)->column('route,thumb_route');
            }

        //整个数组，提出数据
        foreach ($data as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $arr[$k]['url'] =  $k1;
                $arr[$k]['poster'] =  $v1;
            }
        }
        return $arr;

    }

}
