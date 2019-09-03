<?php
/**
 * Created by PhpStorm.
 * User: JAVA是世界上最好的语言
 * Date: 2019/4/2
 * Time: 15:51
 */
namespace app\index\model;

use think\Model;

class Dynamic extends Model
{
    public function add($data)
    {
        $result = $this->save($data);
        return $result;
    }
    /*
     * @ author 彼得潘
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
    /*
     * @ author 彼得潘
     */
    public function route()
    {
        return $this->hasMany('Route','route_dy_id','idx_dy_route');
    }
}