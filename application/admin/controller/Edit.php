<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;


class Edit extends Controller
{
//    public function index()
//    {
//        return $this->fetch();
//    }

    public function tuedit($route_dy_id)
    {
        $result = Db::query(
            "select d.openid, describes, tabname, r.route_dy_id, thumb_route, r.create_time, count(thumb_route) as toutel, is_hot
            from dy_dynamic as d
			inner join dy_route as r on d.idx_dynamic = r.route_dy_id
			left join dy_tabs as t on 	d.idx_dynamic = t.idx_tabs
            where d.idx_dynamic = r.route_dy_id
            and d.idx_dynamic = t.idx_tabs
            and r.route_dy_id = $route_dy_id
			GROUP BY route_dy_id"
        );
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
        $this->assign('arr',$arr);
        return view('edit/tuedit');
    }

    public function update(Request $request)
    {
        $data = $request->post();
        $re = Db::table('dy_dynamic')->where('idx_dynamic',$data['route_dy_id'])
            ->update(['describes' => $data['describes']]);
        $rs = Db::table('dy_tabs')->where('idx_tabs',$data['route_dy_id'])
            ->update(['tabname' => $data['tabname']]);
        if(!empty($re) || !empty($rs)) {
            $this->success('更新成功',url('admin/index/tulist'));
        } else {
            $this->error('更新失败',url('admin/index/tulist'));
        }
    }


    public function usedit($id)
    {
//        $re = Db::query('select * from dy_user where id = $id');
        $re = Db::table('dy_user')->where('id',$id)->find();
//        halt($re);
//        echo $re['openid'];exit;
        $this->assign('re',$re);
        return view('edit/usedit');
    }


    public function usupdate(Request $request)
    {
        $data = $request -> post();
        $re = Db::table('dy_user')->where('id',$data['id'])
            ->update([
                'nickname' => $data['nickname'],
                'user_profile' => $data['user_profile'],
                'user_fans' => $data['user_fans'],
                'user_pics' => $data['user_pics']
                ]);
//        halt($data);
        if($re) {
            $this->success('更新成功',url('admin/index/uslist'));
        }else {
            $this->error('更新失败',url('admin/index/uslist'));
        }
    }



    public function fredit($id)
    {
//        halt($id);
        $rs = Db::table('dy_friend')
            ->alias('f')
            ->join('dy_user u', 'f.fr_openid = u.openid')
            ->where('f.fr_openid = u.openid')
            ->where('f.id',$id)
            ->field('f.id, u.nickname, u.headimgurl, f.openid, f.fr_openid')
            ->select();


        //user表上的所有用户ID
        $oid = Db::query('select openid,id from dy_user');

        $this->assign('rs',$rs);
        $this->assign('oid',$oid);
        return $this->fetch('edit/fredit');
//        return view('edit/fredit');
    }

    public function frupdate(Request $request)
    {
        $data = $request ->post();
//        halt($data);
        $re = Db::table('dy_user')->where('id',$data['openid'])->select();
        $fr = Db::table('dy_user')->where('id',$data['fr_openid'])->select();
//        halt($fr);
        foreach($re as $k => $v)
        {
            $rt = Db::table('dy_friend')->where('id',$data['id'])
                ->update([
                    'openid' => $v['openid'],

                ]);
//            halt($rg);

        }

        foreach($fr as $k => $v)
        {
            $rh = Db::table('dy_friend')->where('id',$data['id'])
                ->update([
                    'fr_openid' => $v['openid'],
                ]);
            $rg = Db::table('dy_user')->where('openid',$v['openid'])
                ->update([
                    'nickname' => $data['nickname'],
                ]);

        }


        if(empty($rh) || empty($rt) || empty($rg)) {
            $this->error('修改失败',url('admin/index/frlist'));
        }else {
            $this->success('修改成功',url('admin/index/frlist'));
        }


    }

    public function faedit($idx_fan)
    {
        $fa = Db::table('dy_fans')
            ->alias('f')
            ->join('dy_user u', 'f.fan_id = u.openid')
            ->where('f.fan_id = u.openid')
            ->where('f.idx_fan',$idx_fan)
            ->field('f.idx_fan, u.nickname, u.headimgurl, f.openid, f.fan_id')
            ->select();

//        halt($fa);
        //user表上的所有用户ID
        $oid = Db::query('select openid,id from dy_user');

        $this->assign('fa',$fa);
        $this->assign('oid',$oid);
        return $this->fetch('edit/faedit');
//        halt($idx_fan);
    }


    public function faupdate(Request $request)
    {
        $data = $request ->post();
//        halt($data);
        $re = Db::table('dy_user')->where('id',$data['openid'])->select();
        $fr = Db::table('dy_user')->where('id',$data['fan_id'])->select();
//        halt($fr);
        foreach($re as $k => $v)
        {
            $rt = Db::table('dy_fans')->where('idx_fan',$data['id'])
                ->update([
                    'openid' => $v['openid'],

                ]);
//            halt($rg);

        }

        foreach($fr as $k => $v)
        {
            $rh = Db::table('dy_fans')->where('idx_fan',$data['id'])
                ->update([
                    'fan_id' => $v['openid'],
                ]);
            $rg = Db::table('dy_user')->where('openid',$v['openid'])
                ->update([
                    'nickname' => $data['nickname'],
                ]);

        }


        if(empty($rh) || empty($rt) || empty($rg)) {
            $this->error('修改失败',url('admin/index/falist'));
        }else {
            $this->success('修改成功',url('admin/index/falist'));
        }


    }
}