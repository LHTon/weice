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
        $appid = $_GET["appid"];
        $secret = $_GET["appSecret"];
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";
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
        $arr = json_encode($str,true);
        $openid = $arr['openid'];
        $re = Db::table('dy_user')->where('openid',$openid)->select();
        if($re) {

        } else {
            $insert = Db::table('dy_user')
                ->insert([
                    'openid' => $openid,
                ]);
        }
    }

}