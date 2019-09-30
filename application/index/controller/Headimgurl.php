<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

header('Access-Control-Allow-Origin: *');

class Headimgurl extends Controller
{
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

    //头像和昵称列表
    public function headimglist()
    {
        $data = input('post.');

        $info = Db::name('user')
            ->where('openid',$data['openid'])
            ->field('nickname,headimgurl')
            ->select();

        foreach ($info as $k => $v)
        {
           $arr = [
               'nickname' => $v['nickname'],
               'headimgurl' => $v['headimgurl']
           ];
        }
        halt($arr);

    }
}