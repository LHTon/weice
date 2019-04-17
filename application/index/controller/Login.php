<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

header('Access-Control-Allow-Origin: *');

class Login extends Controller
{

    //处理微信登录小程序的授权
    public function index()
    {
        $code = $_GET["code"];
//配置appid
        $appid = $_GET["appid"];
//配置appscret
        $secret = $_GET["appSecret"];

//api接口
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";
//获取GET请求
        function httpGet($url){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 500);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_URL, $url);
            $res = curl_exec($curl);
            curl_close($curl);
            return $res;
        }
//发送
        $str = httpGet($api);
        echo $str;


    }

}