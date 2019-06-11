<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function login()
    {
        if (request()->isPost()) {
            $username = request()->post('username');
            $password = request()->post('password');
            if (empty($username) || empty($password)) {
                $this->error('用户名或密码不能为空');
            }
            $userInfo = db('admin')->where('username', $username)->find();
            if (!$userInfo) {
                $this->error('用户名不存在');
            }
            if ($password != $userInfo['password']) {
                $this->error('密码错误');
            }
        }
        return view('index/index');
    }
}