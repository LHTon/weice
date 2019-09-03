<?php
/**
 * Created by PhpStorm.
 * User: JAVA是世界上最好的语言
 * Date: 2019/4/2
 * Time: 16:20
 */
namespace app\index\model;

use think\Model;

class User extends Model
{
    function dynamic()
    {
        return $this->hasMany('Dynamic','openid','openid');
    }
    function friend()
    {
        return $this->hasMany('Friend','openid','id');
    }
}