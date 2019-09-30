<?php
/**
 * Created by PhpStorm.
 * User: 加油鸭
 * Date: 2019/5/27
 * Time: 12:09
 */

namespace app\index\controller;


use app\index\model\Dynamic;
use app\index\model\Fans;
use app\index\model\User;
use think\Controller;

class Message extends Controller
{
    /*
     * 获取openid
     */
    public function openid()
    {
        $dy['openid'] = $_POST['openid'];
        return $dy;
    }

    /*
     * $query 传入当前图集的资源ID，查询图集的所有图片总和！
     */
    public function count($query){
        $RouteModel = new Dynamic();
        $count = 0;
        for ($i = 0; $i<count($query); $i++) {
            $route = $RouteModel->route()->where('route_dy_id',$query[$i])->count('route_dy_id');
            $count += $route;
        }
        return $count ;
    }

    /*
     * 上新（1个月为周期。1个月内没有上传新图片，则数据为归0；1个月上传新图片张数为上新的数据）
     */
    public function img_time(){
        $openid = $this->openid();
        $UserModel = new User();
        //获取当月的图集 每月1号清0
        $tuji = $UserModel->dynamic()->where('openid' , $openid['openid'])->whereTime('create_time','m')->column('idx_dynamic');
        $count = $this->count($tuji);
        return $count;
    }
    /*
     * 获取关注度
     */
    public function attention()
    {
        $openid = $this->openid();
        $UserModel = new User();
        $user_profile = $UserModel->where('openid' , $openid['openid'])->value('user_profile');
        return $user_profile;

    }
    /*
     * 获取图集相册(张)
     */
    public function image()
    {
        $openid = $this->openid();
        $UserModel = new User();
        $tuji = $UserModel->dynamic()->where('openid',$openid['openid'])->column('idx_dynamic');
        $count = $this->count($tuji);
        return $count;
    }
    /*
     * 粉丝数（被关注总和）
     */
    public function fans()
    {
        $openid = $this->openid();
        $FansModel = new Fans();
        $fans = $FansModel->where('openid',$openid['openid'])->order('create_time')->column('fan_id');
        $count = count($fans);
        return $count;
    }
    public function index(){
        //获取上新图集
        $img_time = $this->img_time();
        //获取关注度
        $attention = $this->attention();
        //获取所有图集
        $image = $this->image();
        //获取粉丝
        $fans = $this->fans();
        $array = ['img_time'=>$img_time,'attention'=>$attention,'image'=>$image,'fans'=>$fans];
        $json = json_encode($array);
        return$json;
    }

}