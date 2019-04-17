<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

header('Access-Control-Allow-Origin: *');

class Headimgurl extends Controller
{
    public function index()
    {
        $openid = $_GET['openid'];
        $nickname = $_GET['nickname'];
        $headimgurl = $_GET['headimgurl'];

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