<?php
/**
 * Created by PhpStorm.
 * User: JAVA是世界上最好的语言
 * Date: 2019/4/2
 * Time: 15:53
 */
namespace app\home\model;

use think\Model;

class Tabs extends Model
{
    public function add($data) {
        $result = $this->save($data);
        return $result;
    }
}