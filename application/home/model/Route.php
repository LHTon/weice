<?php
/**
 * Created by PhpStorm.
 * User: JAVA是世界上最好的语言
 * Date: 2019/3/13
 * Time: 8:42
 */
namespace app\home\model;

use think\Model;

class Route extends Model
{
    public function add($data) {
//        $data['type'] = 1;
        $result = $this -> save($data);
        return $result;
    }


}
