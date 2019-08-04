<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\admin\model\User as UserModel;
header('Access-Control-Allow-Origin: *');
class Index extends Controller
{
    public function index() {
        return $this->fetch();
    }

    public function tulist()
    {

//        $result = Db::query(
//            "select d.openid, describes, tabname, r.route_dy_id, thumb_route, r.create_time, count(thumb_route) as toutel, is_hot
//            from dy_dynamic as d
//			inner join dy_route as r on d.idx_dynamic = r.route_dy_id
//			left join dy_tabs as t on 	d.idx_dynamic = t.idx_tabs
//            where d.idx_dynamic = r.route_dy_id
//            and d.idx_dynamic = t.idx_tabs
//			GROUP BY route_dy_id"
//        );
//        halt($result);

        $result = Db::table('dy_dynamic')
            ->alias('d')
            ->join('dy_route r','d.idx_dynamic = r.route_dy_id')
            ->join('dy_tabs t','d.idx_dynamic = t.idx_tabs')
            ->where('d.idx_dynamic = r.route_dy_id')
            ->where('d.idx_dynamic = t.idx_tabs')
            ->field('d.openid, describes, tabname, r.route_dy_id, thumb_route, r.create_time, count(thumb_route) as toutel, is_hot')
            ->group('r.route_dy_id')
            ->paginate(5);
//        halt($arr);

        foreach($result as $rt)
        {
            $arr[] = [
                'openid'    => $rt['openid'],
                'describes' => $rt['describes'],
                'tabname'   =>  $rt['tabname'],
                'route_dy_id'   => $rt['route_dy_id'],
                'thumb_route' => $rt['thumb_route'],
                'create_time' => $rt['create_time'],
                'toutel' => $rt['toutel'],
                'is_hot' => $rt['is_hot']

            ];
        }
        $page = $result->render();
        $this->assign('page', $page);
        $this->assign('arr',$arr);
        return view('index/tulist');
//
    }





    public function volist()
    {
        return $this->fetch('index\volist');
    }

    public function uslist()
    {
//       $re = Db::query('select * from dy_user');
        $re = Db::table('dy_user')->where('id','>',0)->paginate(5);
        $page = $re->render();
        $this->assign('page', $page);
        $this->assign('re',$re);
        return view('index\uslist');




    }

    public function frlist()
    {
        $fr = Db::table('dy_friend')
            ->alias('f')
            ->join('dy_user u', 'f.fr_openid = u.openid')
            ->where('f.fr_openid = u.openid')
            ->field('f.id, u.nickname, u.headimgurl, f.openid, f.fr_openid')
            ->group('f.id')
            ->paginate(5);
        $page = $fr->render();
        $this->assign('page', $page);
        $this->assign('fr',$fr);
        return $this->fetch('index\frlist');
    }

    public function falist()
    {
        $fa = Db::table('dy_fans')
            ->alias('f')
            ->join('dy_user u', 'f.fan_id = u.openid')
            ->where('f.fan_id = u.openid')
            ->field('f.idx_fan, u.nickname, u.headimgurl, f.openid, f.fan_id')
            ->group('f.idx_fan')
            ->paginate(5);
        $page = $fa->render();
        $this->assign('page',$page);
        $this->assign('fa',$fa);
        return $this->fetch('index\falist');
    }
}