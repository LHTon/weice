<?php
namespace app\admin\controller;

use think\Controller;

class Edit extends Controller
{
//    public function index()
//    {
//        return $this->fetch();
//    }

    public function tuedit()
    {
        return $this->fetch('edit\tuedit');
    }
}