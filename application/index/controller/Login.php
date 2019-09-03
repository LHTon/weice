<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use app\index\common\Curl;

header('Access-Control-Allow-Origin: *');

class Login extends Controller
{
    public function index()
    {
        $data = input('post.');
//配置appid
        $appid = 'wx30cbd5bf82ee6334';
//配置appscret
        $secret = '4ecf0ed139067bea03c335fb3200edac';
//api接口
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$data['code']}&grant_type=authorization_code";

//获取GET请求
        function httpGet($url)
        {
//            $method=strtoupper($method);
            $header = array("Accept-Charset: utf-8");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
            //if($method=='POST'){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data='');
            //}
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($ch);
            return $res;
        }

//发送
        $str = httpGet($api);
        echo $str;
        $arr = json_decode($str, true);
        $openid = $arr['openid'];
        $re = Db::table('dy_user')->where('openid',$openid)->select();
        if($re){

        } else {
            $insert = Db::table('dy_user')
                ->insert([
                    'openid' => $openid,
                ]);
        }
    }
}

