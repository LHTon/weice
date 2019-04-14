<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

header('Access-Control-Allow-Origin: *');

class Headimgurl extends Controller
{
    //将微信的头像和用户名存入数据库
    public function index()
    {
        $openid = $_POST['openid'];
        $nickname = $_POST['nickname'];
        $headimgurl = $_POST['headimgurl'];

        $re = Db::name('user')
            ->where('nickname',$nickname)
            ->where('openid',$openid)
            ->select();
        if($re) {
            return 0;
        } else {
            $se = Db::name('user')
                ->where('openid',$openid)
                ->update(['nickname' => $nickname, 'headimgurl' => $headimgurl]);
            if($se) {
                return 1;
            } else {
                return 0;
            }
        }

    }
}