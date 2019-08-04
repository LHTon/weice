<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

header('Access-Control-Allow-Origin: *');
class Add extends Controller
{
    public function index()
    {
        return $this->fetch('add/tuadd');
    }

    public function voadd()
    {
        return $this->fetch('add/voadd');
    }

    public function usadd()
    {
        return $this->fetch('add/usadd');
    }

    public function fradd()
    {
        $oid = Db::query('select openid,id from dy_user');
        $this->assign('oid',$oid);
        return $this->fetch('add/fradd');
    }

    public function faadd()
    {
        $oid = Db::query('select openid,id from dy_user');
        $this->assign('oid',$oid);
        return $this->fetch('add/faadd');
    }
}