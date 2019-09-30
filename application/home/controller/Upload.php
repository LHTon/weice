<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 2019/8/9
 * Time: 23:34
 */
namespace app\home\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Image;
use app\home\model\Route as RouteModel;
use think\Loader;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class Upload extends Controller
{
    public function index(Request $request)
    {
        header('Access-Control-Allow-Origin: *');

        $data = input('post.');
        $file = request()->file('video');
        $files = request()->file('image');
//        halt($file);
        if ($file) {


            //将视频存储在七牛云上
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
//            }elseif($_FILES['video']['type']=='audio/mp3'){
//                $key = 'audio'.time().'.mp3';
//            }else{
//                $key = 'png'.time().'.png';
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





              //将视频储存在本地上的
//            $filePath = "V";
//            $filePaths = ROOT_PATH . 'public' . DS . 'uploads' . DS . $filePath;
//            if (!file_exists($filePaths)) {
//                mkdir($filePaths, 0777, true);
//            }
//            $info = $file->validate(['size'=>104857600,'ext'=>'svg,mp4'])->move($filePaths);
//            if ($info) {
//                $viopath = 'uploads/' . $filePath . '/' . $getSaveName = str_replace("\\", "/", $info->getSaveName());
//                $re = 'http://weicess.com/weice/public/' . $viopath;
//                $routeid = time().rand(1,10000);
//                $describes = [
//                    'idx_dynamic' => $routeid,
//                    'openid'     => $data['openid'],
//                    'describes'  => $data['describes'],
//                    'idx_tabs'   => $data['idx_tabs'],
//                    'type'       => 1
////
//                ];
//                $res = model('Dynamic') -> add($describes);
//                if($res) {
//                    echo '添加描述成功';
//                } else {
//                    echo '添加描述失败';
//                }
//                $da = [
//                    'route_dy_id' => $routeid,
//                    'route'       => $re,
//                ];
//                $se = model('Route')->add($da);
//                if($se) {
//                    return 1;
//                } else {
//                    return 0;
//                }
//
//            } else {
//                // 上传失败获取错误信息
//                return $file->getError();
//            }
        }

        if($files)
        {
            $filePath = "T";
            $toutle = count($files);
            foreach ($files as $file) {
                if ($file) {
                    $filePaths = ROOT_PATH . 'public' . DS . 'uploads' . DS . $filePath;
                    if (!file_exists($filePaths)) {
                        mkdir($filePaths, 0777, true);
                    }

                    $info = $file->move($filePaths);
                    if ($info) {

                        $imgpath = 'uploads/' . $filePath . '/' . $getSaveName = str_replace("\\","/",$info->getSaveName());
                        $image = \think\Image::open($imgpath);
                        $date_path = 'uploads/' . $filePath . '/thumb/' . date('Ymd');
                        if (!file_exists($date_path)) {
                            mkdir($date_path, 0777, true);
                        }
                        $thumb_path = $date_path . '/' . $info->getFilename();
                        $image->thumb(110, 110, Image::THUMB_CENTER)->save($thumb_path);
                        $re[] = 'http://weicess.com/weice/public/'.$imgpath;
                        $se[] = 'http://weicess.com/weice/public/'.$thumb_path;
                    } else {
                        // 上传失败获取错误信息
                        return $file->getError();
                    }
                }
            }
            $dt = time().rand(1,10000);

            //将描述存入到描述表中
            $describes = [
                'idx_dynamic' => $dt,
                'openid'     => $data['openid'],
                'describes'  => $data['describes'],
                'albumid'    => $data['albumid'],
                'idx_tabs'   => $data['idx_tabs']

            ];
            $res = model('Dynamic') -> add($describes);
            if($res) {
                echo '添加描述成功';
            } else {
                echo '添加描述失败';
            }

            //图片存入资源表中
            switch($toutle){
                case 1:{
                    $route = new RouteModel();
                    $data = [
                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=> $se[0]]
                    ];
                    $result = $route->saveAll($data);
                    if($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                };break;
                case 2:{
                    $route = new RouteModel();
                    $data = [
                        ["route_dy_id" => $dt, "route" => $re[0], "thumb_route" => $se[0]],
                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]]
                    ];
                    $result = $route->saveAll($data);
                    if($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                };break;
                case 3:{
                    $route = new RouteModel();
                    $data = [
                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]]
                    ];
                    $result = $route->saveAll($data);
                    if($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                };break;
                case 4:{
                    $route = new RouteModel();
                    $data = [
                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]]
                    ];
                    $result = $route->saveAll($data);
                    if($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                };break;
                case 5:{
                    $route = new RouteModel();
                    $data = [
                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]],
                        ["route_dy_id" => $dt, "route" => $re[4],"thumb_route"=>$se[4]]
                    ];
                    $result = $route->saveAll($data);
                    if($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                };break;
                case 6:{
                    $route = new RouteModel();
                    $data = [
                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]],
                        ["route_dy_id" => $dt, "route" => $re[4],"thumb_route"=>$se[4]],
                        ["route_dy_id" => $dt, "route" => $re[5],"thumb_route"=>$se[5]]
                    ];
                    $result = $route->saveAll($data);
                    if($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                };break;
                case 7:{
                    $route = new RouteModel();
                    $data = [
                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]],
                        ["route_dy_id" => $dt, "route" => $re[4],"thumb_route"=>$se[4]],
                        ["route_dy_id" => $dt, "route" => $re[5],"thumb_route"=>$se[5]],
                        ["route_dy_id" => $dt, "route" => $re[6],"thumb_route"=>$se[6]]
                    ];
                    $result = $route->saveAll($data);
                    if($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                };break;
                case 8:{
                    $route = new RouteModel();
                    $data = [
                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]],
                        ["route_dy_id" => $dt, "route" => $re[4],"thumb_route"=>$se[4]],
                        ["route_dy_id" => $dt, "route" => $re[5],"thumb_route"=>$se[5]],
                        ["route_dy_id" => $dt, "route" => $re[6],"thumb_route"=>$se[6]],
                        ["route_dy_id" => $dt, "route" => $re[7],"thumb_route"=>$se[7]]
                    ];
                    $result = $route->saveAll($data);
                    if($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                };break;
                case 9:{
                    $route = new RouteModel();
                    $data = [
                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]],
                        ["route_dy_id" => $dt, "route" => $re[4],"thumb_route"=>$se[4]],
                        ["route_dy_id" => $dt, "route" => $re[5],"thumb_route"=>$se[5]],
                        ["route_dy_id" => $dt, "route" => $re[6],"thumb_route"=>$se[6]],
                        ["route_dy_id" => $dt, "route" => $re[7],"thumb_route"=>$se[7]],
                        ["route_dy_id" => $dt, "route" => $re[8],"thumb_route"=>$se[8]]
                    ];
                    $result = $route->saveAll($data);
                    if($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                };break;
                default;
            }

        }

    }

    /**
     * 将用户所有的标签名，在上传之前发给前端
     */
    public function tablist()
    {
        header('Access-Control-Allow-Origin: *');
        $data = input('post.');

        $result = Db::name('tabs')
            ->where('openid' ,$data['openid'])
            ->field('idx_tabs as id ,tabname')
            ->select();

        $re = json_encode($result);
        echo $re;
    }
}