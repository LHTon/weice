<?php
/**
 * Created by PhpStorm.
 * User: JAVA是世界上最好的语言
 * Date: 2019/4/5
 * Time: 21:08
 */
namespace app\index\controller;

use think\Controller;
use think\Db;

header('Access-Control-Allow-Origin: *');
class Albumlst extends Controller
{
    //查询所有图集的列表
    public function index()
    {
       $openid = $_POST['openid'];
        $result = Db::query(
            "select describes ,tabname ,r.route_dy_id, thumb_route, r.create_time, count(thumb_route) as toutel, is_hot
            from dy_dynamic as d
			inner join dy_route as r on d.idx_dynamic = r.route_dy_id
			left join dy_tabs as t on 	d.idx_tabs = t.idx_tabs
            where d.idx_dynamic = r.route_dy_id
            and d.idx_tabs = t.idx_tabs
            and d.openid = '$openid'
			GROUP BY route_dy_id"
        );
//        halt($result);

        foreach($result as $rt)
        {
            $arr[] = [
                'describes' => $rt['describes'],
                'tabname'   =>  [ $rt['tabname']],
                'route_dy_id'   => $rt['route_dy_id'],
                'thumb_route' => $rt['thumb_route'],
                'create_time' => $rt['create_time'],
                'toutel' => $rt['toutel'],
                'is_hot' => $rt['is_hot']

            ];
        }
        $cs = json_encode($arr);
        echo $cs;
    }

    //处理图集设置为热点图集
    public function hot()
    {
        $is_hot = $_POST['is_hot'];
        $routeid = $_POST['route_dy_id'];
        $re = Db::name('route')
            ->where('route_dy_id', $routeid)
            ->update(['is_hot' => $is_hot]);
        if($re) {
            return 1;
        } else {
            return 0;
        }
    }

    //删除图集
    public function delete()
    {
        $data = input('post.');
        $result = model('Route')->where('route_dy_id',$data['route_dy_id'])->delete();
        if($result) {
            return 1;
        } else {
           return 0;
        }
    }
}