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
    public function index(Request $request)
    {
// 获取表单上传文件
        $files = $request->file('image');
        exit;
        $item = [];
        foreach($files as $file){
// 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $item = $info->getInfo();
            }else{
// 上传失败获取错误信息
                $this->error($file->getError());
            }
        }
//        $this->success('文件上传成功'.implode('<br/>',$item));
        dump($item);
    }



    public function up(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $dy['openid'] = $_POST['openid'];
        $dy['describes'] = $_POST['describes'];
        $ta['openid'] = $_POST['openid'];
        $ta['tabname'] = $_POST['tabname'];

        $filePath = "T";
        $files = request()->file('image');
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
                    $re[] = 'http://39.97.184.156/weice/public/'.$imgpath;
                    $se[] = 'http://39.97.184.156/weice/public/'.$thumb_path;
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



