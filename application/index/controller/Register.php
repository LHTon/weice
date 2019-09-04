<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Register extends Controller
{
    public function index()
    {
        $re = Session::get('qqcode');
        halt($re);
        $data = input('post.');
//        halt($data);

       //查询数据库这个邮箱有没有已注册
        $se = Db::name('user')
            ->where('email',$data['email'])
            ->select();
//        halt($se);



        $info = Db::name('user')
            ->where('openid',$data['openid'])
            ->field('email')
            ->select();
//        halt($info);

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
}