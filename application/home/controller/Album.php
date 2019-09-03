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
    public function index(Request $request)
    {
        $data = $request -> post();

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
}