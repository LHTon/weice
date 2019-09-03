<?php
/**
 * Created by PhpStorm.
 * User: 加油鸭
 * Date: 2019/6/4
 * Time: 20:04
 */

namespace app\index\controller;


use app\index\model\Dynamic;
use app\index\model\User;
use app\index\model\Route;
use think\Controller;

class Video extends Controller
{
    /*
     * @return josn
     * @idx_dynamic 资源ID
     * @describes 视频描述
     * @create_time 创建时间
     * @route 视频路径
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
        $UserModel = new User();
        $RouteModel = new Route();
        $DymanicModel = new Dynamic();
        //获取资源ID
        $dymanic = $UserModel->dynamic()->where([
            'openid' => $openid['openid'],
            'type' => '1'
        ])->column('idx_dynamic,describes,create_time');
        foreach ( $dymanic as $key => $value) {
            $route_id[] = $key;
        }
        //获取视频资源ID
            foreach ( $route_id as $k => $v) {
                $data[] = $RouteModel->where('route_dy_id' ,$v)->column('route_dy_id,thumb_route');
            }

        //将二维数组变一维数组
        foreach ($data as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $arr[$k1] = $v1;
            }
        }
        //合并数组
        foreach ($dymanic as $key => $value) {
            foreach ($arr as $k => $v) {
                if ($key == $k) {
                    $dymanic[$key]['route'] = $v;
                }
            }
        }
        return $dymanic;

    }



}