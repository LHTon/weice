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
use app\index\model\Friend;
use think\Controller;

class Message extends Controller
{
    /*
     * 上新（1个月为周期。1个月内没有上传新图片，则数据为归0；1个月上传新图片张数为上新的数据）
     */
    public function img_time($Query)
    {
        $DynamicModel = new Dynamic();
        //获取当月的图集 每月1号清0
        $tuji = $DynamicModel->where('openid', $Query)->whereTime('create_time','month')->count('idx_dynamic');
        return $tuji;
    }

    /*
     * 获取关注度
     */
    public function attention($Query)
    {
        $FriendModel = new Friend();
        $user_profile = $FriendModel->where('openid', $Query)->value('fr_openid');
        return $user_profile;

    }

    /*
     * 获取图集相册(张)
     */
    public function image($Query)
    {
        $DynamicModel = new Dynamic();
        //获取资源ID
        $tuji = $DynamicModel->where('openid', $Query)->column('idx_dynamic');
        //获取图片总和
        $count = $DynamicModel->route()->whereIn('route_dy_id',$tuji)->count('route_dy_id');
        return $count;
    }

    /*
     * 粉丝数（被关注总和）
     */
    public function fans($Query)
    {
        $FansModel = new Fans();
        $fans = $FansModel->where('openid', $Query)->count('fan_id');
        return $fans;
    }

    public function index()
    {
        $dy = $_POST['openid'];
        //获取上新图集
        $img_time = $this->img_time($dy);
        //获取关注度
        $attention = $this->attention($dy);
        //获取所有图集
        $image = $this->image($dy);
        //获取粉丝
        $fans = $this->fans($dy);

        $array = ['img_time' => $img_time, 'attention' => $attention, 'image' => $image, 'fans' => $fans];
        $json = json_encode($array);
        return $json;
    }

}