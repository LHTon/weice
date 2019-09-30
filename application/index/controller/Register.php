<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Cache;

class Register extends Controller
{
    public function index()
    {
        $re = Cache::get('qqcode');
        $data = input('post.');

       //查询数据库这个邮箱有没有已注册
        $se = Db::name('user')
            ->where('email',$data['email'])
            ->select();



        $info = Db::name('user')
            ->where('openid',$data['openid'])
            ->field('email')
            ->select();

        foreach ($info as $k => $v)
        {
            if (!empty($v['email']) || !empty($se)) {
                return "账号已注册";
            }
            if (empty($v['email']) && empty($se)) {
                if ($data['qqcode'] == $re) {
                    $info = Db::name('user')
                        ->where('openid',$data['openid'])
                        ->update(
                            [
                                'email' => $data['email'],
                                'password' => $data['password']
                            ]
                        );
                    if ($info) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    return "验证码错误";
                }

            }
        }

    }

    public function account()
    {
        $data = input('post.');

        $info = Db::name('user')
            ->where('openid', $data['openid'])
            ->field('email')
            ->select();

        foreach ($info as $k => $v) {
            if (!empty($v['email'])) {
                return 0;
            } else {
                return 1;
            }
        }
    }
}