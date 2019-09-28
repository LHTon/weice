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
use app\index\model\Fans;
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

        //判断好友人数是否为空，为空时返回0
        if (count($fr_openid) == 0) {
            return 0;
        }
        $pic_name = $this->pic_name($fr_openid);
        $pic_name  = json_encode($pic_name);
        return $pic_name;
    }

    /*
     * 关注好友
     * $openid      本人openid
     * $openid      好友用户openid
     * $nickname    好友用户名称
     * $headimgurl  好友用户头像
     * return  添加成功,返回json格式的$openid，$nickname，$headimgurl
     * return  添加失败，数据表中已存在，已经是好友
     *
     */
    public function friend()
    {
        //获取本人openid
        $openid = action('index/Message/openid');
        //获取关注好友openid
        $friend_openid = $_POST['fr_openid'];
        //获取关注好友昵称
        $nickname = $_POST['nickname'];
        //获取关注好友头像
        $headimgurl = $_POST['headimgurl'];
//        $param = request()->get();

        $attention = $this->attention($openid, $friend_openid);
        if ($attention == 1){
            $data = ['fr_openid' => $friend_openid,'nickname'=>$nickname,'headimgurl'=>$headimgurl];
            $data = json_encode($data);
            return $data;
        } else {
            return "你们已经是关注好友";
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
     *
     * return  1（添加成功） | 0（添加失败，数据库字段已存在，已经是好友）
     *
     */
    public function attention($openid, $fr_openid)
    {
        $FriendModel = new Friend();
        $FansModel = new Fans();
        //查询是否已经是好友
        $sql  =  $FriendModel->where([
            'openid' => $openid['openid'],
            'fr_openid' => $fr_openid
        ])->select();
        //不是好友则添加好友
        if (empty($sql)) {
            //关注好友添加到数据库好友表中
            $fr_insert = $FriendModel->data([
                'openid' => $openid['openid'],
                'fr_openid' => $fr_openid
            ])->save();
            //查询好友跟粉丝是否是互粉关系
            $fr_select = $FriendModel->where([
                'openid' => $fr_openid,
                'fr_openid' => $openid['openid']
            ])->select();
            if (empty($fr_select)) {
                //关注好友添加到数据库粉丝表中
                $fa_insert = $FansModel->data([
                    'fan_id' => $openid['openid'],
                    'openid' => $fr_openid,
                    'status' => '0'
                ])->save();
            }else {
                //关注好友添加到数据库粉丝表中
                $fa_insert = $FansModel->data([
                    'fan_id' => $openid['openid'],
                    'openid' => $fr_openid,
                    'status' => '1'
                ])->save();
                //确定互粉关系
                $update = $FansModel->where([
                    'openid' => $openid['openid'],
                    'fan_id' => $fr_openid
                ])->update(['status' => '1']);
            }
            return $fa_insert;
        }else{
            return 0;
        }
    }

    /*
     * 遍历粉丝列表
     * @param openid        用户ID
     * @param nickname      头像
     * @param headimgurl    用户名
     * @param status        状态值（true表示互粉，false表示没有）
     */
    public function fans()
    {
        $FansModel = new Fans();
        //获取本人openid
        $openid = action('index/Message/openid');
        //查找数据库粉丝表
        $sql = $FansModel->where('openid',$openid['openid'])->column('fan_id');
//        halt($sql);
        //判断粉丝表是否为空
        if (empty($sql)){
            return 0;
        }
        //获取openid，用户名，头像
        $pic_name = $this->pic_name($sql);

        //查找数据库粉丝表跟状态值
        $sql = $FansModel->where('openid',$openid['openid'])->column('fan_id,status');
        //状态值1或0改为true跟false
        foreach ($sql as $key => $value) {
            if ($value == 1) {
                $sql[$key] = true;
            } else {
                $sql[$key] = false;
            }
        }
        //合并数组字段
        foreach ($pic_name as $key => $value) {
            foreach ($sql as $k => $v) {
                if ($value['openid'] == $k) {
                    $pic_name[$key]['status'] = $v;
                }
            }
        }
//        halt($pic_name);
        $fans = json_encode($pic_name);
        return $fans;
    }

    /*
     * 取消关注
     */
    public function unfollow()
    {
        $FriendModel = new Friend();
        $FansModel = new Fans();
        //获取本人openid
        $openid = action('index/Message/openid');
        //获取关注好友openid
        $friend_openid = $_POST['fr_openid'];
        //判断是否已经是关注好友
        $sql = $FriendModel->where([
            'openid' => $openid['openid'],
            'fr_openid' => $friend_openid
        ])->select();
        //是好友则删除好友
        if (!empty($sql)) {
            //取消关注
            $fr_delete = $FriendModel->where([
                'openid' => $openid['openid'],
                'fr_openid' => $friend_openid
            ])->delete();
            //取消好友粉丝，删除本人
            $fans_delete = $FansModel->where([
                'openid' => $friend_openid,
                'fan_id' => $openid['openid']
            ])->delete();
            //判断是否是互粉关系
            $fans_deletes = $FansModel->data([
                'openid' => $openid['openid'],
                'fan_id' => $friend_openid
            ])->select();
            //互粉关系则取消互粉关系
            if (!empty($fans_deletes)) {
                $data = [
                    'openid' => $openid['openid'],
                    'fan_id' => $friend_openid
                ];
                $save = ['status' => '0'];
                $FansModel->save($save,$data);
            }
            return "已取消关注";

        } else {
            return "你们不是好友关系";
        }
    }

    /*
     * @param openid 用户ID
     * @return lastadd 昨天新增
     * @return monthadd 本月新增
     * @return countfans 所有粉丝
     */
    public function fansTime()
    {
        $FansModel = new Fans();
        //获取本人openid
        $openid = action('index/Message/openid');
        //查询昨天新增粉丝
        $lastadd = $FansModel->where('openid',$openid['openid'])->whereTime('create_time','yesterday')->count();
        //查询本月新增粉丝
        $monthadd = $FansModel->where('openid',$openid['openid'])->whereTime('create_time','month')->count();
        //查询所有粉丝
        $countfans = $FansModel->where('openid',$openid['openid'])->count();

        //总和
        $data = [
            'lastadd'       => $lastadd,
            'monthadd'     => $monthadd,
            'countfans'    => $countfans
        ];
        $data = json_encode($data);
        return $data;
    }

}