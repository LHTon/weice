<?php
namespace app\home\controller;

use think\Controller;
use think\Loader;
use think\Db;
use app\home\model\Dynamic;

header('Access-Control-Allow-Origin: *');
class qrcode extends Controller
{
    public function qrcode()
    {
        //拿到openid  查找用户表内是否有该用户  没有则拒绝生成二维码   有则查看是否已生成二维码   有生成则发送数据   没有则生成
        $openid=input('post.openid');//得到用户openid
        $dealer =  Db::name("user")->where(['openid' => $openid])->field('qrcode,nickname,headimgurl ')->select();
        foreach ($dealer as $k => $v) {
            if ($v['qrcode'] == '') {
                $appid = 'wx30cbd5bf82ee6334';
                $secret = '4ecf0ed139067bea03c335fb3200edac';//AppSecret(小程序密钥)
                $url_access_token = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
                $json_access_token = $this -> sendCmd($url_access_token,array());
                $arr_access_token = json_decode($json_access_token,true);
                $access_token = $arr_access_token['access_token'];
                if(!empty($access_token)) {
                    $url = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token='.$access_token;
                    $data = '{"path": "pages/my/my?openid='.$openid.'", "width": 150}';
                    $result = $this -> sendCmd($url,$data);
                    $name = $openid.time();
                    file_put_contents('./uploads/qrcode/code-'.$name.'.jpg',$result);
                    //存储二维码路径
                    $arr = 'https://lhtong.cn/weice/public/uploads/qrcode/code-'.$name.'.jpg';
                    $res=Db::name("user")
                        ->where(['openid' => $openid])
                        ->update(
                            [
                                'qrcode' => $arr
                            ]
                        );
                    if ($res) {
                        return $arr;
                    }
                } else {

                    return 'ACCESS TOKEN为空！';
                }

            } else {
                return $v['qrcode'];
            }
        }
    }

    //生成带图集id二维码的
    public function sqrcode()
    {
        $da = input('post.');
        $dynamic = new Dynamic();
        $result = $dynamic ->where('idx_dynamic',$da['route_dy_id'])
            ->field('sqrcode')
            ->find();
//        halt($result);
        if (!empty($result->sqrcode)) {
            return $result->sqrcode;
        } else {
            $appid = 'wx30cbd5bf82ee6334';
            $secret = '4ecf0ed139067bea03c335fb3200edac';//AppSecret(小程序密钥)
            $url_access_token = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
            $json_access_token = $this -> sendCmd($url_access_token,array());
            $arr_access_token = json_decode($json_access_token,true);
            $access_token = $arr_access_token['access_token'];
            if(!empty($access_token)) {
                $url = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token='.$access_token;
                $data = '{"path": "pages/my/my?route_dy_id='.$da['route_dy_id'].'", "width": 150}';
                $result = $this -> sendCmd($url,$data);
                $name = time();
                file_put_contents('./uploads/qrcode/s-'.$name.'.jpg',$result);
                //存储二维码路径
                $arr = 'https://lhtong.cn/weice/public/uploads/qrcode/s-'.$name.'.jpg';
                $res=Db::name("dynamic")
                    ->where('idx_dynamic',$da['route_dy_id'])
                    ->update(
                        [
                            'sqrcode' => $arr
                        ]
                    );
                if ($res) {
                    return $arr;
                }
            } else {

                return 'ACCESS TOKEN为空！';
            }
        }


    }


    /**
     * 发起请求
     * @param  string $url  请求地址
     * @param  string $data 请求数据包
     * @return   string      请求返回数据
     */
    function sendCmd($url,$data)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检测
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:')); //解决数据包大不能提交
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);
        }
        curl_close($curl); // 关键CURL会话
        return $tmpInfo; // 返回数据
    }

//    //生成带参数二维码
//    public function index()
//    {
//        Loader::import('phpqrcode.phpqrcode', EXTEND_PATH);
//        $data = 'http://www.baidu.com';
//        $path =  str_replace("\\", "/", ROOT_PATH ."public/images/" . time() .".png");
//        \QRcode::png($data,$path,QR_ECLEVEL_L, 7, 2);
//        $paths =  substr($path, 16);
//        $pat = 'http://weicess.com/weice/public/' . $paths;
//        return $pat;
//    }
}




