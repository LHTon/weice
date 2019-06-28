<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Del extends Controller
{
    public function tudel($route_dy_id)
    {
        $re = Db::table('dy_route')->where('route_dy_id',$route_dy_id)->delete();
        $rs = Db::table('dy_dynamic')->where('idx_dynamic',$route_dy_id)->delete();
        $rt = Db::table('dy_tabs')->where('idx_tabs',$route_dy_id)->delete();
        if(empty($re) || empty($rs) || empty($rt)) {
            $this->error('删除失败',url('admin/index/tulist'));
        } else {
            $this->success('删除成功',url('admin/index/tulist'));

        }
    }

    public function usdel($id)
    {
        $rt = Db::table('dy_user')->where('id',$id)->select();
        $re = Db::table('dy_user')->where('id',$id)->delete();

        if(empty($re)) {
            $this->error('删除失败',url('admin/index/uslist'));
        } else {
            $this->success('删除成功',url('admin/index/uslist'));

        }
    }

    public function frdel($id)
    {
        $r = Db::table('dy_friend')->where('id',$id)->delete();
        if(empty($r)) {
            $this->error('删除失败',url('admin/index/frlist'));
        } else {
            $this->success('删除成功',url('admin/index/frlist'));

        }
    }

    public function fadel($idx_fan)
    {
        $rs = Db::table('dy_fans')->where('idx_fan',$idx_fan)->delete();
        if(empty($rs)) {
            $this->error('删除失败',url('admin/index/falist'));
        } else {
            $this->success('删除成功',url('admin/index/falist'));

        }
    }
}