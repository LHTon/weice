<?php
/**
 * Created by PhpStorm.
 * User: 加油鸭
 * Date: 2019/4/14
 * Time: 13:28
 */

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\index\model\Route as RouteModel;
header('Access-Control-Allow-Origin: *');
class Index extends Controller
{
    /**
     * 获取图集唯一的标识符
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function route_dy_id()
    {
        //获取用户openid
        $dy['openid'] = $_GET['openid'];
        $sql = Db::table('dy_user')
            ->alias('u')
            ->join('dy_dynamic d', 'u.openid = d.openid')
            ->join('dy_route r', 'd.idx_dynamic = r.route_dy_id')
            ->where('u.openid',$dy['openid'])
            ->field('r.route_dy_id')
            ->order('r.idx_dy_route','dsc')
            ->group('r.route_dy_id')
            ->select();
        //去除重复项
        $bb = array_unique($sql, SORT_REGULAR);
        foreach ($bb as $key) {
            $arr[] = $key['route_dy_id'];
        }
        return $arr;
    }


    /*获取用户部门信息
     * route_dy_id      id
     * describes        描述
     * create_time      时间
     * */
    private function describe()
    {
        //获取用户openid
        $dy['openid'] = $_GET['openid'];
        $sql = Db::table('dy_user')
            ->alias('u')
            ->join('dy_dynamic d', 'u.openid = d.openid')
            ->join('dy_route r', 'd.idx_dynamic = r.route_dy_id')
            ->where('u.openid',$dy['openid'])
            ->field('r.route_dy_id, d.describes, r.create_time')
            ->order('r.idx_dy_route','dsc')
            ->group('r.route_dy_id')
            ->select();
        //去除重复项
        $bb = array_unique($sql, SORT_REGULAR);
        return $bb;
    }

    //查询SQL个人所有数据
    private function all()
    {
        //获取用户openid
        $dy['openid'] = $_GET['openid'];
        //查询SQL个人所有数据
        $sql = Db::table('dy_user')
            ->alias('u')
            ->join('dy_dynamic d', 'u.openid = d.openid')
            ->join('dy_route r', 'd.idx_dynamic = r.route_dy_id')
            ->where('u.openid',$dy['openid'])
            ->field('r.route_dy_id, d.describes, r.thumb_route, r.create_time, r.idx_dy_route, r.route')
            ->order('r.idx_dy_route','dsc')
            ->select();

//       print_r($sql) ;
        return $sql;
    }

    /*
     * 查询用户头像以及用户名
     */
    private function user_id()
    {
        //获取用户openid
        $dy['openid'] = $_GET['openid'];
        $sql = Db::table('dy_user')
            ->where('openid',$dy['openid'])
            ->field('nickname, headimgurl')
            ->select();
        return $sql;
    }

    /** 返回josn方法
     * @param Request $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function show(Request $request)
    {
//        header('Access-Control-Allow-Origin: *');

        //获取所有图集唯一的标识符
        $arr = $this->route_dy_id();
        $count = count($arr);
//        print_r($arr);

        //获取所有用户唯一的属性
        $describe = $this->describe();
//        print_r($describe);
        //获取用户openid
        $dy['openid'] = $_GET['openid'];

        //获取需要用到的所有信息
        $sql = $this->all();

        //获取用户名，头像
        $user = $this->user_id();

        //获取缩列图
        foreach($sql as $key=>$value){
            for ($i = 0; $i<$count; $i++)
                if ($value['route_dy_id'] == $arr[$i] ){
                    $newarr[$value['route_dy_id']][] =  $value['thumb_route'];
                }
        }

        //获取原图
        foreach($sql as $key=>$value){
            for ($i = 0; $i<$count; $i++)
                if ($value['route_dy_id'] == $arr[$i] ){
                    $newarr_route[$value['route_dy_id']][] =  $value['route'];
                }
        }
//        print_r($newarr_route);


        //整个缩略图数组
        foreach ($describe as $k1 => $v1) {
            foreach ($newarr as $k2 => $v2) {
                if ($v1['route_dy_id'] == $k2) {
                    $describe[$k1]['thumb_route'] = $v2;
                }
            }
        }


        //整个原图数组
        foreach ($describe as $k1 => $v1) {
            foreach ($newarr_route as $k2 => $v2) {
                if ($v1['route_dy_id'] == $k2) {
                    $describe[$k1]['route'] = $v2;
                }
            }
        }

        //整个头像、用户名数组
        foreach ($describe as $k1 => $v1) {
            foreach ($user as $k2 => $v2) {
                foreach ($v2 as $key => $value) {
                    $describe[$k1]['nickname'] = reset($v2);
                    $describe[$k1]['headimgurl'] = $value;

                }
            }
        }

        //返回json对象
        $describe = json_encode($describe);
        print_r($describe);

    }

}