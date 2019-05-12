<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

header('Access-Control-Allow-Origin: *');

class Login extends Controller
{
    public function index()
    {
        import('wxBizDataCrypt', EXTEND_PATH);
        function httpGet($url) {
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
//        $nickname      = $_POST['nickName'];
//        $headimgurl    = $_POST['headimgurl'];
        $code          = $_POST['code'];
        $iv            = $_POST['iv'];
        $encryptedData = $_POST['encryptedData'];
        $appid      = $_POST['appid'];//小程序唯一标识   (在微信小程序管理后台获取)
        $appsecret  = $_POST['appSecret'];//小程序的 app secret (在微信小程序管理后台获取)
        $grant_type = "authorization_code"; //授权（必填）

        $params = "appid=".$appid."&secret=".$appsecret."&js_code=".$code."&grant_type=".$grant_type;
        $url = "https://api.weixin.qq.com/sns/jscode2session?".$params;

        $res = json_decode(httpGet($url),true);
        //json_decode不加参数true，转成的就不是array,而是对象。 下面的的取值会报错  Fatal error: Cannot use object of type stdClass as array in
        $sessionKey = $res['session_key'];//取出json里对应的值

        $pc = new \WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data);

        if ($errCode == 0) {
            print($data . "\n");
        } else {
            print($errCode . "\n");
        }

    }

}