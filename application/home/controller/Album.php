<?php
namespace app\home\controller;

use think\Controller;
use think\Db;
use think\Request;

header('Access-Control-Allow-Origin: *');

class Album extends Controller
{
    /**
     * 新建相册
     */
    public function index()
    {
        $data = input('post.');

        $se = Db::name('album')
            ->where('openid',$data['openid'])
            ->where('name',$data['name'])
            ->select();

        if (empty($se)) {
            $re = Db::name('album')
                ->insert(
                    [
                        'name' => $data['name'],
                        'openid' => $data['openid']
                    ]
                );
            if($re) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return '相册名已存在';
        }

    }

    /**
     *显示相册列表
     */
    public function lst()
    {
        $data = input('post.');

        $result = Db::table('dy_album')
            ->alias('a')
            ->join('dy_dynamic d','a.openid = d.openid')
            ->join('dy_route r', 'd.idx_dynamic = r.route_dy_id')
            ->where('d.openid', $data['openid'])
            ->where('a.id = d.albumid')
            ->field('a.id, name, a.create_time as time, thumb_route, count(thumb_route) as toutle')
            ->order('d.create_time' ,'desc')
            ->group('a.id')
            ->select();

        $re = json_encode($result);
        return $re;
    }

    /**
     * 图片的列表
     */
    public function pic()
    {
        $data = input('post.');
        // 获取用户的所有图片
        $result = Db::table('dy_route')
            ->alias('r')
            ->join('dy_dynamic d' ,'d.idx_dynamic = r.route_dy_id')
            ->where('openid' ,$data['openid'])
            ->where('d.type = 0')
            ->field('route ,thumb_route ,r.create_time')
            ->order('r.create_time' ,'desc')
            ->select();
        $i = json_encode($result);
        return $i;
    }

    /**
     * 视频列表
     */
    public function video()
    {
        $data = input('post.');
        //获取用户的所有视频
        $result = Db::table('dy_route')
            ->alias('r')
            ->join('dy_dynamic d' ,'d.idx_dynamic = r.route_dy_id')
            ->where('openid' ,$data['openid'])
            ->where('d.type = 1')
            ->field('route ,r.create_time')
            ->order('r.create_time' ,'desc')
            ->select();
        $v = json_encode($result);
        return $v;
    }

    /**
     * 新建标签
     */
    public function tabs()
    {
        $data = input('post.');

        $se = Db::name('tabs')
            ->where('openid',$data['openid'])
            ->where('tabname',$data['tabname'])
            ->select();

        if (empty($se)) {
            $result = Db::name('tabs')
                ->insert(
                    [
                        'openid' => $data['openid'],
                        'tabname' => $data['tabname']
                    ]
                );
            if ($result) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return '标签名已存在';
        }
    }
}