<?php
/**
 * Created by PhpStorm.
 * User: JAVA是世界上最好的语言
 * Date: 2019/3/10
 * Time: 19:58
 */

namespace app\admin\controller;

use think\Db;
use think\Request;
use think\Image;
use app\admin\model\Route as RouteModel;
use app\admin\model\User as UserModel;


header('Access-Control-Allow-Origin: *');
class Route extends \think\Controller
{
    //用户列表的上传功能
    public function index(Request $request)
    {
        $data = $request -> post();
//        halt($data);
        $filePath = "img";
        $files = request()->file('image');
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
                    $re[] = 'http://127.0.0.1/weice/public/'.$imgpath;
                    $se[] = 'http://127.0.0.1/weice/public/'.$thumb_path;
                } else {
                    // 上传失败获取错误信息
                    return $file->getError();
                }
            }
        }

//
        $user = new UserModel();
        $data = [
               [ "openid" => $data['openid'],
                "nickname" => $data['nickname'],
                "headimgurl" => $se[0],
                "user_profile" => $data['user_profile'],
                "user_fans"    => $data['user_fans'],
                "user_pics"    => $data['user_pics'],
               ]
        ];
        $result = $user->saveAll($data);
        if($result) {
            $this->success('添加成功',url('admin/index/uslist'));
        } else {
            $this->error('添加失败',url('admin/index/uslist'));
        }

    }





    //好友列表上传功能
    public function fradd(Request $request)
    {

        $data = $request ->post();
//        halt($data);
        $re = Db::table('dy_user')->where('id',$data['openid'])->select();
        $fr = Db::table('dy_user')->where('id',$data['fr_openid'])->select();
        foreach($re as $k => $v)
        {
            $rt = Db::table('dy_friend')
                ->insert([
                    'openid' => $v['openid'],
                ]);

        }


        foreach($fr as $k => $v)
        {
            $rg = Db::query('select * from dy_friend order by id desc limit 1');
            foreach($rg as $k => $i)
            {
                $rh = Db::table('dy_friend')->where('openid',$i['openid'])
                    ->update([
                        'fr_openid' => $v['openid'],
                    ]);
            }
        }

        if(empty($rh) || empty($rt)) {
            $this->error('添加失败',url('admin/index/frlist'));
        }else {
            $this->success('添加成功',url('admin/index/frlist'));
        }



    }










    //粉丝列表上传功能
    public function faadd(Request $request)
    {
        $data = $request ->post();
//        halt($data);
        $re = Db::table('dy_user')->where('id',$data['openid'])->select();
        foreach($re as $k => $v)
        {
            $rt = Db::table('dy_fans')
                ->insert([
                    'openid' => $v['openid'],
                ]);
        }
        $fg = Db::table('dy_user')->where('id',$data['fan_id'])->select();
        foreach($fg as $k => $v)
        {
            $rg = Db::query('select * from dy_fans order by idx_fan desc limit 1');
//            halt($rg);
            foreach($rg as $k => $i)
            {
                $rh = Db::table('dy_fans')->where('openid',$i['openid'])
                    ->update([
                        'fan_id' => $v['openid'],
                    ]);
            }
        }


        if(empty($rh) || empty($rt)) {
            $this->error('添加失败',url('admin/index/falist'));
        }else {
            $this->success('添加成功',url('admin/index/falist'));
        }



    }




    //图集上传功能
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
                    $date_path = 'uploads/' . $filePath . '/thumb/' . date('Ymd');
                    if (!file_exists($date_path)) {
                        mkdir($date_path, 0777, true);
                    }
                    $thumb_path = $date_path . '/' . $info->getFilename();
                    $image->thumb(110, 110, Image::THUMB_CENTER)->save($thumb_path);
                    $re[] = 'http://127.0.0.1/weice/public/'.$imgpath;
                    $se[] = 'http://127.0.0.1/weice/public/'.$thumb_path;
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
                    $this->success('添加成功',url('admin/index/tulist'));
                } else {
                    $this->error('添加失败',url('admin/index/tulist'));
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



