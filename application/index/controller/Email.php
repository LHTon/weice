<?php

namespace app\index\controller;

use think\Controller;
use phpmailer\PHPMailer\PHPMailer;
use phpmailer\PHPMailer\Exception;
use think\Cache;
//use think\Session;

class Email extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        import('phpmailer.src.Exception', EXTEND_PATH);
        import('phpmailer.src.PHPMailer', EXTEND_PATH);
        import('phpmailer.src.SMTP', EXTEND_PATH);

        $data = input('post.');
        $title = "注册微册邮箱的验证码";
        $code=rand(100000,999999);
        Cache::set('qqcode',$code);
        echo (Cache::get('qqcode'));
//        Session::set('qqcode',$code);
//        echo (Session::get('qqcode'));
        $content = "邮件内容是您注册微册的验证码是：".$code."，如果非本人操作无需理会！";

        $mail = new PHPMailer();
        //        exit();
        try {
            //服务器配置
            $mail->CharSet ="UTF-8";                     //设定邮件编码
            $mail->SMTPDebug = 0;                        // 调试模式输出
            $mail->isSMTP();                             // 使用SMTP
            $mail->Host = 'smtp.163.com';                // SMTP服务器
            $mail->SMTPAuth = true;                      // 允许 SMTP 认证
            $mail->Username = '15876766724@163.com';                // SMTP 用户名  即邮箱的用户名
            $mail->Password = 'lht990211';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
            $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
            $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

            $mail->setFrom('15876766724@163.com', 'Mailer');  //发件人
            $mail->addAddress($data['email'], 'Joe');  // 收件人
            //$mail->addAddress('ellen@example.com');  // 可添加多个收件人
            $mail->addReplyTo('15876766724@163.com', 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致

            //Content
            $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
            $mail->Subject = $title;
            $mail->Body    = $content ."<br />". date('Y-m-d H:i:s');
            $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';

            $mail->send($data['email'],$title,$content);
            echo '邮件发送成功';
        } catch (Exception $e) {
            echo '邮件发送失败: ', $mail->ErrorInfo;
        }

    }




}