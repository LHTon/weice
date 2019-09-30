<?php
namespace app\home\controller;

use think\Controller;
use think\Db;
header('Access-Control-Allow-Origin:*');

class Login extends Controller
{
    public function index()
    {
        $data = input('post.');

        $result = Db::name('user')
                ->where('email',$data['email'])
                ->select();
        if ($result) {
            foreach ($result as $key => $value) {
                if ($value['password'] == $data['password']) {
                    return  $value['openid'];
                } else {
                    echo "密码错误";
                }
            }
        } else {
            echo "邮箱未注册";
        }
    }
}