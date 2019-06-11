<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

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
        return $this->fetch('add/fradd');
    }

    public function faadd()
    {
        return $this->fetch('add/faadd');
    }
}