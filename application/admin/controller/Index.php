<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index() {
        return $this->fetch();
    }

    public function tulist()
    {
//        $result = Db::query(
//            "select describes, tabname, r.route_dy_id, thumb_route, r.create_time, count(thumb_route) as toutel, is_hot
//            from dy_dynamic as d
//			inner join dy_route as r on d.idx_dynamic = r.route_dy_id
//			left join dy_tabs as t on 	d.idx_dynamic = t.idx_tabs
//            where d.idx_dynamic = r.route_dy_id
//            and d.idx_dynamic = t.idx_tabs
//			GROUP BY route_dy_id"
//        );
//
//        foreach($result as $rt)
//        {
//            $arr[] = [
//                'describes' => $rt['describes'],
//                'tabname'   =>  [ $rt['tabname']],
//                'route_dy_id'   => $rt['route_dy_id'],
//                'thumb_route' => $rt['thumb_route'],
//                'create_time' => $rt['create_time'],
//                'toutel' => $rt['toutel'],
//                'is_hot' => $rt['is_hot']
//
//            ];
//        }
//        print_r($arr);exit;
//        return view('index\tulist',$arr);
        return view('index\tulist');
    }





    public function volist()
    {
        return $this->fetch('index\volist');
    }

    public function uslist()
    {
        return $this->fetch('index\uslist');
    }

    public function frlist()
    {
        return $this->fetch('index\frlist');
    }

    public function falist()
    {
        return $this->fetch('index\falist');
    }
}