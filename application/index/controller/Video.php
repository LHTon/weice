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
     * @idx_dynamic 资源ID
     * @describes 视频描述
     * @create_time 创建时间
     * @route 视频路径
     * @idx_tabs 标签
     */
    public function index()
    {
        //获取用户ID
        $openid = action('index/Message/openid');
        $video = $this->video($openid);
        $videos = json_encode($video);
        return $videos;
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
        ])->column('idx_dynamic,describes,create_time,idx_tabs');

        //替换查询掉$dymanic字段的标签名字，返回$dymanic
        foreach ($dymanic as $key => $value) {
            $tabs = $TabsModel->where('idx_tabs',$value['idx_tabs'])->value('tabname');
            $dymanic[$key]['idx_tabs'] = $tabs;
        }

        /*
         * rreturn:返回0是代表无视频：请添加视频
         */
        if (empty($dymanic) ) {
            return "0";
        }


        foreach ( $dymanic as $key => $value) {
            $route_id[] = $key;
        }


        //获取视频资源ID
            foreach ( $route_id as $k => $v) {
                $data[] = $RouteModel->where('route_dy_id' ,$v)->column('route_dy_id,route,thumb_route');
            }

        //将二维数组变一维数组
        foreach ($data as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $arr[$k1] = $v1;
            }
        }
//        print_r($arr);
        //合并数组
        foreach ($dymanic as $key => $value) {
            foreach ($arr as $k => $v) {
                if ($key == $k) {
                    $dymanic[$key]['route'] = $v;
                }
            }
        }
//        halt($dymanic);
        return $dymanic;

    }
}