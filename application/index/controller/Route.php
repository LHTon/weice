<?php
/**
 * Created by PhpStorm.
 * User: JAVA是世界上最好的语言
 * Date: 2019/3/10
 * Time: 19:58
 */

namespace app\index\controller;

use think\Db;
use think\Request;
use think\Image;
use app\index\model\Route as RouteModel;


header('Access-Control-Allow-Origin: *');
class Route extends \think\Controller
{
    public function index() 
    {
//        return 'http://39.97.184.156/weice/public/uploads/erweima.jpg';
        return $this->fetch();
    }




    //上传视频和图片的功能
//    public function up(Request $request)
//    {
//        header('Access-Control-Allow-Origin: *');
//
//        $data = input('post.');
//        halt($data);
//
//        $file = request()->file('video');
//        $files = request()->file('image');
//        if ($file) {
//            $filePath = "V";
//            $filePaths = ROOT_PATH . 'public' . DS . 'uploads' . DS . $filePath;
//            if (!file_exists($filePaths)) {
//                mkdir($filePaths, 0777, true);
//            }
//            $info = $file->validate(['size'=>104857600,'ext'=>'svg,mp4'])->move($filePaths);
//            if ($info) {
//                $viopath = 'uploads/' . $filePath . '/' . $getSaveName = str_replace("\\", "/", $info->getSaveName());
//                $re = 'http://110.64.211.77/weice/public/' . $viopath;
//                $routeid = time().rand(1,10000);
//                $describes = [
//                    'idx_dynamic' => $routeid,
//                    'openid'     => $data['openid'],
//                    'describes'  => $data['describes'],
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
//        }
//
//        if($files)
//        {
//            $filePath = "T";
//            foreach ($files as $file) {
//                $toutle = count($file);
//                halt($toutle);
//                if ($file) {
//                    $filePaths = ROOT_PATH . 'public' . DS . 'uploads' . DS . $filePath;
//                    if (!file_exists($filePaths)) {
//                        mkdir($filePaths, 0777, true);
//                    }
//
//                    $info = $file->move($filePaths);
//                    if ($info) {
//
//                        $imgpath = 'uploads/' . $filePath . '/' . $getSaveName = str_replace("\\","/",$info->getSaveName());
//                        $image = \think\Image::open($imgpath);
//                        $date_path = 'uploads/' . $filePath . '/thumb/' . date('Ymd');
//                        if (!file_exists($date_path)) {
//                            mkdir($date_path, 0777, true);
//                        }
//                        $thumb_path = $date_path . '/' . $info->getFilename();
//                        $image->thumb(110, 110, Image::THUMB_CENTER)->save($thumb_path);
//                        $re[] = 'http://110.64.211.77/weice/public/'.$imgpath;
//                        $se[] = 'http://110.64.211.77/weice/public/'.$thumb_path;
//                    } else {
//                        // 上传失败获取错误信息
//                        return $file->getError();
//                    }
//                }
//            }
//            $dt = time().rand(1,10000);
//            //将标签名存入到标签表中
//            $tabs = [
//                'idx_tabs' => $dt,
//                'openid'     => $data['openid'],
//                'tabname'  => $data['tabname'],
//            ];
//            $res = model('Tabs') -> add($tabs);
//            if($res) {
//                echo '添加标签成功';
//            } else {
//                echo '添加标签失败';
//            }
//
//            //将描述存入到描述表中
//            $describes = [
//                'idx_dynamic' => $dt,
//                'openid'     => $data['openid'],
//                'describes'  => $data['describes'],
//            ];
//            $res = model('Dynamic') -> add($describes);
//            if($res) {
//                echo '添加描述成功';
//            } else {
//                echo '添加描述失败';
//            }
//
//            //图片存入资源表中
//            switch($toutle){
//                case 1:{
//                    $route = new RouteModel();
//                    $data = [
//                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]]
//                    ];
//                    $result = $route->saveAll($data);
//                    if($result) {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//                };break;
//                case 2:{
//                    $route = new RouteModel();
//                    $data = [
//                        ["route_dy_id" => $dt, "route" => $re[0], "thumb_route" => $se[0]],
//                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]]
//                    ];
//                    $result = $route->saveAll($data);
//                    if($result) {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//                };break;
//                case 3:{
//                    $route = new RouteModel();
//                    $data = [
//                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
//                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
//                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]]
//                    ];
//                    $result = $route->saveAll($data);
//                    if($result) {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//                };break;
//                case 4:{
//                    $route = new RouteModel();
//                    $data = [
//                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
//                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
//                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
//                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]]
//                    ];
//                    $result = $route->saveAll($data);
//                    if($result) {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//                };break;
//                case 5:{
//                    $route = new RouteModel();
//                    $data = [
//                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
//                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
//                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
//                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]],
//                        ["route_dy_id" => $dt, "route" => $re[4],"thumb_route"=>$se[4]]
//                    ];
//                    $result = $route->saveAll($data);
//                    if($result) {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//                };break;
//                case 6:{
//                    $route = new RouteModel();
//                    $data = [
//                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
//                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
//                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
//                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]],
//                        ["route_dy_id" => $dt, "route" => $re[4],"thumb_route"=>$se[4]],
//                        ["route_dy_id" => $dt, "route" => $re[5],"thumb_route"=>$se[5]]
//                    ];
//                    $result = $route->saveAll($data);
//                    if($result) {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//                };break;
//                case 7:{
//                    $route = new RouteModel();
//                    $data = [
//                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
//                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
//                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
//                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]],
//                        ["route_dy_id" => $dt, "route" => $re[4],"thumb_route"=>$se[4]],
//                        ["route_dy_id" => $dt, "route" => $re[5],"thumb_route"=>$se[5]],
//                        ["route_dy_id" => $dt, "route" => $re[6],"thumb_route"=>$se[6]]
//                    ];
//                    $result = $route->saveAll($data);
//                    if($result) {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//                };break;
//                case 8:{
//                    $route = new RouteModel();
//                    $data = [
//                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
//                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
//                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
//                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]],
//                        ["route_dy_id" => $dt, "route" => $re[4],"thumb_route"=>$se[4]],
//                        ["route_dy_id" => $dt, "route" => $re[5],"thumb_route"=>$se[5]],
//                        ["route_dy_id" => $dt, "route" => $re[6],"thumb_route"=>$se[6]],
//                        ["route_dy_id" => $dt, "route" => $re[7],"thumb_route"=>$se[7]]
//                    ];
//                    $result = $route->saveAll($data);
//                    if($result) {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//                };break;
//                case 9:{
//                    $route = new RouteModel();
//                    $data = [
//                        ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]],
//                        ["route_dy_id" => $dt, "route" => $re[1],"thumb_route"=>$se[1]],
//                        ["route_dy_id" => $dt, "route" => $re[2],"thumb_route"=>$se[2]],
//                        ["route_dy_id" => $dt, "route" => $re[3],"thumb_route"=>$se[3]],
//                        ["route_dy_id" => $dt, "route" => $re[4],"thumb_route"=>$se[4]],
//                        ["route_dy_id" => $dt, "route" => $re[5],"thumb_route"=>$se[5]],
//                        ["route_dy_id" => $dt, "route" => $re[6],"thumb_route"=>$se[6]],
//                        ["route_dy_id" => $dt, "route" => $re[7],"thumb_route"=>$se[7]],
//                        ["route_dy_id" => $dt, "route" => $re[8],"thumb_route"=>$se[8]]
//                    ];
//                    $result = $route->saveAll($data);
//                    if($result) {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//                };break;
//                default;
//            }
//
//        }
//
//    }
    public function up(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $dy['openid'] = $_POST['openid'];
        $dy['describes'] = $_POST['describes'];
        $ta['openid'] = $_POST['openid'];
        $ta['tabname'] = $_POST['tabname'];

        $filePath = "T";
        $files = request()->file('image');

//        halt($files);

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
//                    halt($image);
                    $date_path = 'uploads/' . $filePath . '/thumb/' . date('Ymd');
                    if (!file_exists($date_path)) {
                        mkdir($date_path, 0777, true);
                    }
                    $thumb_path = $date_path . '/' . $info->getFilename();
                    $image->thumb(110, 110, Image::THUMB_CENTER)->save($thumb_path);

                    $re[] = 'http://weicess.com/weice/public/'.$imgpath;
                    $se[] = 'http://weicess.com/weice/public/'.$thumb_path;
//                    $re[] = 'http://110.64.211.77/weice/public/'.$imgpath;
//                    $se[] = 'http://110.64.211.77/weice/public/'.$thumb_path;

                } else {
                    // 上传失败获取错误信息
                    return $file->getError();
                }
            }
        }

        $dt = time().rand(1,10000);
//        $ds = time().rand(100,100000);
        $res = Db::table('dy_dynamic')->insert(["idx_dynamic" => $dt, "openid" => $dy['openid'],"describes" => $dy['describes']]);
        $reg = Db::table('dy_tabs')->insert(["idx_tabs" => $dt, "openid" => $ta['openid'],"tabname" => $ta['tabname']]);
        switch($toutle){
            case 1:{
                $route = new RouteModel();
                $data = [
                    ["route_dy_id" => $dt, "route" => $re[0],"thumb_route"=>$se[0]]
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





