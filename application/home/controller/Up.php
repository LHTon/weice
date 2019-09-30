<?php

namespace app\home\controller;

use think\Controller;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use think\Request;
use think\Loader;

class Up extends Controller
{
    /**
     * 将图片储存在七牛云上
     */
    public function index(Request $request)
    {
         if(request()->isPost()) {
             $file = request()->file('image');
             // 要上传图片的本地路径
             $filePath = $file->getRealPath();
             $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);  //后缀
             //获取当前控制器名称
             //$controllerName=$this->getContro();
             // 上传到七牛后保存的文件名
             $key = substr(md5($file->getRealPath()), 0, 5) . time() . '.' . $ext;
             Loader::import('phpsdk.autoload',EXTEND_PATH);
//             require_once APP_PATH . '/../vendor/qiniu/autoload.php';
             // 需要填写你的 Access Key 和 Secret Key
             $accessKey = 'HQGQglK3BL_-9p_BbrDh3dL7ng5fW8IxOiGX8gnA';
             $secretKey = 'HQPkbjauhrn_pqR1qPy-brs5GOsZYgC7wHywiaUV';
             // 构建鉴权对象
             $auth = new Auth($accessKey, $secretKey);
             // 要上传的空间
             $bucket = 'weices';
             $domain = 'weices.s3-cn-east-1.qiniucs.com';
             $token = $auth->uploadToken($bucket);
             // 初始化 UploadManager 对象并进行文件的上传
             $uploadMgr = new UploadManager();
             //dump($uploadMgr);exit;
             // 调用 UploadManager 的 putFile 方法进行文件的上传
             list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
             if ($err !== null) {
                 return ["err" => 1, "msg" => $err, "data" => ""];
             } else {
                 //返回图片的完整URL
                 return json(["err" => 0, "msg" => "上传完成", "data" =>'pxjkvuz0y.bkt.clouddn.com/' . $ret['key']]);
             }
         }
    }


    /**
     * 将视频储存在七牛云上，并获取到视频的截图
     */

    public function upload()
    {

        Loader::import('phpsdk.autoload',EXTEND_PATH);
        $data = input('post.');


        $accessKey = 'HQGQglK3BL_-9p_BbrDh3dL7ng5fW8IxOiGX8gnA';
        $secretKey = 'HQPkbjauhrn_pqR1qPy-brs5GOsZYgC7wHywiaUV';
        $auth = new Auth($accessKey, $secretKey);  //实例化
        $bucket='weices';//存储空间
        $token = $auth->uploadToken($bucket);
        $uploadMgr = new UploadManager();
        $filePath = $_FILES['video']['tmp_name'];//'./php-logo.png';  //接收图片信息
        if($_FILES['video']['type']=='video/mp4'){
            $key = 'video'.time().'.mp4';
        }elseif($_FILES['video']['type']=='audio/mp3'){
            $key = 'audio'.time().'.mp3';
        }else{
            $key = 'png'.time().'.png';
        }
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        $vpic = 'http://pxjkvuz0y.bkt.clouddn.com/' . $key.'?vframe/jpg/offset/1';
        $path ='http://pxjkvuz0y.bkt.clouddn.com/' . $ret['key'];
        if ($err !== null) {
            echo '上传失败';
        } else{
           echo 1;
        }

        $routeid = time().rand(1,10000);
        $describes = [
            'idx_dynamic' => $routeid,
            'openid'     => $data['openid'],
            'describes'  => $data['describes'],
            'idx_tabs'   => $data['idx_tabs'],
            'type'       => 1
//
        ];
        $res = model('Dynamic') -> add($describes);
        if($res) {
            echo '添加描述成功';
        } else {
            echo '添加描述失败';
        }
        $da = [
            'route_dy_id' => $routeid,
            'route'       => $path,
            'thumb_route' => $vpic
        ];
        $se = model('Route')->add($da);
        if($se) {
            return 1;
        } else {
            return 0;
        }
    }
}
