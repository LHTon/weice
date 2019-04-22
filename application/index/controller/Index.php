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
    //获取所有openid  自己以及关注好友
    public function openid() {
        $dy['openid'] = $_GET['openid'];
        $dyid[] =$dy['openid'];
        $sql = Db::table('dy_user')
            ->alias('u')
            ->join('dy_friend f', 'u.openid = f.openid')
            ->where('u.openid',$dy['openid'])
            ->field('f.fr_openid')
//            ->group('f.fr_openid')
            ->select();
        foreach ($sql as $key => $value){
            foreach ($value as $key1 => $value1){
                $dyid[] = $value1;
            }
        }
        return $dyid;
    }


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
        $dy = $this->openid();
//        $dy['openid'] = $_GET['openid'];
        for($i =0;$i<count($dy); $i++) {
            $sql = Db::table('dy_user')
                ->alias('u')
                ->join('dy_dynamic d', 'u.openid = d.openid')
                ->join('dy_route r', 'd.idx_dynamic = r.route_dy_id')
                ->where('u.openid',$dy[$i])
                ->field('r.route_dy_id')
                ->order('r.create_time','desc')
                ->group('r.route_dy_id')
                ->select();
            $sql1[] = $sql;
        }
        foreach ($sql1 as $key=>$value){
            foreach ($value as $key1=>$value1){
                foreach ($value1 as $k=>$v){
                    $aa[] = $v;
                }
            }
        }
        return $aa;
    }


    /*获取用户部门信息
     * route_dy_id      id
     * describes        描述
     * create_time      时间
     * */
    private function describe()
    {
        //获取用户openid
        $dy = $this->openid();
//        $dy['openid'] = $_GET['openid'];
        for($i =0;$i<count($dy); $i++) {
            $sql = Db::table('dy_user')
                ->alias('u')
                ->join('dy_dynamic d', 'u.openid = d.openid')
                ->join('dy_route r', 'd.idx_dynamic = r.route_dy_id')
                ->where('u.openid', $dy[$i])
                ->field('r.route_dy_id, d.describes,r.create_time')
                ->order('r.create_time', 'desc')
                ->group('r.route_dy_id')
                ->select();
            $sql1[] = $sql;
        }
        //去除重复项
        $bb = array_unique($sql1, SORT_REGULAR);
        foreach ($bb as $key => $value) {
            foreach ($value as $key1 => $value1) {
                $aa[] = $value1;
            }
        }
        return $aa;
    }

    //查询SQL个人所有数据
    private function all()
    {
        //获取用户openid
        $dy = $this->openid();
        //查询SQL个人所有数据
        for($i =0;$i<count($dy); $i++) {
        $sql = Db::table('dy_user')
            ->alias('u')
            ->join('dy_dynamic d', 'u.openid = d.openid')
            ->join('dy_route r', 'd.idx_dynamic = r.route_dy_id')
            ->where('u.openid',$dy[$i])
            ->field('r.route_dy_id, d.describes, r.thumb_route, r.create_time, r.idx_dy_route, r.route')
            ->order('r.create_time','desc')
            ->select();
            $sql1[] = $sql;
        }
//       print_r($sql) ;
        return $sql1;
    }

    /*
     * 查询用户头像以及用户名
     */
    public function user_id()
    {
        //获取用户openid
        $dy = $this->openid();
        //查询SQL个人所有数据
        for($i =0;$i<count($dy); $i++) {
        $sql = Db::table('dy_user')
            ->alias('u')
            ->join('dy_dynamic d', 'u.openid = d.openid')
            ->where('u.openid',$dy[$i])
            ->field('u.nickname, u.headimgurl, d.idx_dynamic')
            ->select();

            $sql1[] = $sql;
        }
        foreach ($sql1 as $key=>$value){
            foreach ($value as $key1=>$value1){
                $ad[] = $value1;
            }
        }
        return $ad;
    }

    /**
     * @return array   day
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function timer(array $array)
    {
        //获取当前时间 & 时 & 分 & 秒
        $today =  date('Y-m-d H:i:s');
        $D =  date('d');
        $H =  date('H');
        $M =  date('i');
        foreach ($array as $key=>$value) {
                $d = substr($value['create_time'],8,2);      //获取创建日期：单位：日
                $h = substr($value['create_time'],11,2);     //获取创建日期：单位：时
                $m = substr($value['create_time'],14,2);     //获取创建日期：单位：时
                if ($D!=$d){
                    $minus = $D-$d;    //判断发布时间与更新时间的时间差：单位：日
                    switch ($minus) {
                        case 1:
                            $array[$key]['create_time'] = "昨天";
                            break;
                        case 2:
                            $array[$key]['create_time'] = "两天前";
                            break;
                        default:
                            $array[$key]['create_time'] = $array[$key]['create_time'];
                            break;
                    }
                }else {
                    $hour = $H-$h;    //判断发布时间与更新时间的时间差：单位：时
                    if ($hour<1){
                        if ($m == $M) {
                            $array[$key]['create_time'] = "刚刚";
                            continue;
                        }else if ($m < $M) {
                            $minute = $M-$m;
                            $array[$key]['create_time'] = $minute."分钟前";
                            continue;
                        }else{
                            $minute = 60-$m+$M;
                            $array[$key]['create_time'] = $minute."分钟前";
                            continue;
                        }
                    } else {
                        $array[$key]['create_time'] = $hour ."小时前";
                    }
                }
            }

        return $array;
    }

    /**

     * @param $oneArray 第一个数组

     * @param $twoArray 第二个数组

     * @param $oneField 第一个数组的字段

     * @param $towField 第二个数组的字段

     * @param $sub 子集索引名1

     * @param $sub 子集索引名2

     * @param bool $is_unset 是否删除子集为空的项

     * @return bool

     */

    function mergeSubArray(&$oneArray, &$twoArray,$oneField, $towField, $sub,$sub1,$is_unset=false)
    {
        if (!is_array($oneArray) || !is_array($twoArray)) {
            return false;
        }
        $result = array();
        foreach ($twoArray as $k => $v) {
            $result[$v[$towField]] = $v;
            $nickname[] = $v['nickname'];
            $headimgurl[] = $v['headimgurl'];
        }
        foreach ($oneArray as $k1 => $v) {
            foreach ($result as $k2 => $item) {
                if ($k2 = $v[$oneField]) {
                    $oneArray[$k1][$sub] = $nickname[$k1] ;
                    $oneArray[$k1][$sub1] = $headimgurl[$k1];
                    if ($is_unset&&empty($oneArray[$k1][$sub])){
                        unset($oneArray[$k1]);
                    }
                    break;//continue;
                }
            }
        }
        $oneArray = array_values($oneArray); //重新生成索引
        return $oneArray;
    }

    /**
     * @return mixed 二维数组排序
     */
    function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }


    /** 返回josn方法
     * @param Request $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function show(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        //获取所有图集唯一的标识符
        $arr = $this->route_dy_id();
//        print_r($arr);

        $count = count($arr);
        //获取所有用户唯一的属性
        $describe = $this->describe();
//        print_r($describe);

        //获取需要用到的所有信息
        $sql = $this->all();
//        print_r($sql);
//        exit();

        //获取用户名，头像
        $user = $this->user_id();

        //获取时间戳
//        $timer = $this->timer();
//               print_r($timer);
//               exit();

        //获取缩列图
        foreach($sql as $key=>$value){
            foreach ($value as $k=>$v)
            for ($i = 0; $i<$count; $i++)
            if ($v['route_dy_id'] == $arr[$i] ){
                $newarr[$v['route_dy_id']][] =  $v['thumb_route'];
            }
        }
//        print_r($newarr);

        //获取原图
//        print_r($sql);
//        exit;
        foreach($sql as $key=>$value){
            foreach ($value as $k=>$v)
                for ($i = 0; $i<$count; $i++)
                    if ($v['route_dy_id'] == $arr[$i] ){
                        $newarr_route[$v['route_dy_id']][] =  $v['route'];
                    }
        }
//        print_r($newarr_route);

//        exit();
        //整个缩略图数组
        foreach ($describe as $k1 => $v1) {
            foreach ($newarr as $k2 => $v2) {
                if ($v1['route_dy_id'] == $k2) {
                    $describe[$k1]['thumb_route'] = $v2;
                }
            }
        }
//        print_r($describe);

//        //整个原图数组
        foreach ($describe as $k1 => $v1) {
            foreach ($newarr_route as $k2 => $v2) {
                if ($v1['route_dy_id'] == $k2) {
                    $describe[$k1]['route'] = $v2;
                }
            }
        }
//                halt($newarr_route);
//        print_r($describe);
//        print_r($user);

        //调用mergeSubArray方法整合数组名字很图片
        $describe = $this->mergeSubArray( $describe,$user,'route_dy_id','idx_dynamic','nickname','headimgurl');

         //返回顺序按时间顺序排列
        $sorted = $this->array_orderby($describe, 'create_time', SORT_DESC);

        //判断当前日期显示
        $describe = $this->timer($sorted);
//        print_r($describe);

        //返回json对象
        $describe = json_encode($describe);
        print_r($describe);

    }

}