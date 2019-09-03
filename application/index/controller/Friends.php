<?php
/**
 * Created by PhpStorm.
 * User: 加油鸭
 * Date: 2019/5/30
 * Time: 15:40
 */

namespace app\index\controller;


use app\index\model\Friend;
use app\index\model\User;
use think\Controller;

class Friends extends Controller
{
    /*
     * 遍历好友列表，按首字体的首字母排列
     */
    public function index()
    {
        $openid = action('index/Message/openid');
        $Friend = new Friend();
        $fr_openid = $Friend->where('openid' , $openid['openid'])->column('fr_openid');
        $pic_name = $this->pic_name($fr_openid);
        $pic_name  = json_encode($pic_name);
        return $pic_name;
    }

    /*
     * 关注好友
     * $openid      好友用户openid
     * $nickname    好友用户名称
     * $headimgurl  好友用户头像
     * return  添加成功,返回json格式的$openid，$nickname，$headimgurl
     * return  添加失败，数据表中已存在，已经是好友
     *
     */
    public function friend()
    {
        $friend_openid = $_GET['openid'];
        $nickname = $_GET['nickname'];
        $headimgurl = $_GET['headimgurl'];
        $param = request()->get();

        $attention = $this->attention($friend_openid);
        if ($attention == 1){
            $data = ['fr_openid' => $friend_openid,'nickname'=>$nickname,'headimgurl'=>$headimgurl];
            $data = json_encode($data);
            return $data;
        } else {
            return "添加失败";
        }

    }

    /*
     * $query 传入用户唯一标识符 openid
     * return 查询头像，用户名
     */
    public function pic_name($query)
    {
        $UserModel = new User();
        for ($i = 0;$i<count($query); $i++) {
            $pic_name[$i] =  $UserModel->where('openid',$query[$i])->column('openid,nickname,headimgurl');
        }
        //将三维数组变二维数组
        foreach ($pic_name as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $arr[$k] = $v1;
            }
        }
        return $arr;
    }
    /*
     * 关注好友
     * $openid      好友用户openid
     * return  1（添加成功） | 0（添加失败，数据库字段已存在，已经是好友）
     *
     */
    public function attention($query)
    {
        //获取本人openid
        $openid = action('index/Message/openid');
        $FriendModel = new Friend();
        $sql  =  $FriendModel->where([
            'openid' => $openid['openid'],
            'fr_openid' => $query
        ])->value('fr_openid');
        if ($sql == $query) {
            return "0";
        }

        //关注好友添加到数据库中
        $insert = $FriendModel->data([
            'openid' => $openid['openid'],
            'fr_openid' => $query
        ])->save();
        return $insert;

    }

}