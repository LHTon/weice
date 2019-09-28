<?php
/**
 * Created by PhpStorm.
 * User: 加油鸭
 * Date: 2019/9/21
 * Time: 13:24
 */

namespace app\index\controller;


use app\index\model\Dynamic;
use app\index\model\Route;
use think\Controller;

class Share extends Controller
{
    public function share()
    {
        //获取图集ID
        $dynanic = $_POST['dynanic'];
        //根据图集ID获取分享类型type，描述
        $head_name = $this->head_name($dynanic);
        //单独拿类型出来，进一步判断是图片或视频
        foreach ($head_name as $key => $value) {
            $type = $key;
        }
        //判断是否是视频还是图片，图片返回二维数组，视频返回一维数组
        if ($type == 0) {
            $pic = $this->route($dynanic);
            foreach ($pic as $key => $value) {
                $array['route'][] = $key;
                $array['thumb_route'][] = $value;
            }
        } else {
            $pic = $this->route($dynanic);
            foreach ($pic as $key => $value) {
                $array['route'] = $key;
                $array['thumb_route'] = $value;
            }
        }
        //数组合并
        foreach ($array as $key => $value) {
            foreach ($head_name as $k => $v) {
                $array['describes'] = $v;
            }
        }
        $pic = json_encode($array);
        return $pic;

    }
    /*
     *@ 根据图集ID，查询描述和类型
     *@ $query 图集ID
     */
    public function head_name($query)
    {
        $DynanicModel = new Dynamic();
        //查询openid
        $sql = $DynanicModel->where('idx_dynamic',$query)->column('describes,type','type');
        return $sql;
    }
    /*
     * @ 根据图集ID，根据类型查询视频或图片
     * @ query 图集ID
     * retrun array
     */
    public function route($query)
    {
        $RouteModel = new Route();
        $sql = $RouteModel->where('route_dy_id',$query)->column('route,thumb_route');
        return $sql;
    }

    /*
     * 二维数组降一维数组
     * @$query 二维数组
     * return $array 一维数组
     */
    public function array2($query)
    {
        foreach ($query as $key=>$value) {
            foreach ($value as $key1 => $value1) {
                $array[$key1] = $value1;
            }
        }
        return $array;
    }



}