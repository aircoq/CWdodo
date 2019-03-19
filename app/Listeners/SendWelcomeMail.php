<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMail implements ShouldQueue//使用ShouldQueue队列发送执行事件
{
    use InteractsWithQueue;//手动访问监听器下面队列任务的 delete 和 release 方法

    public function __construct()
    {
        //
    }

    public function handle(UserRegistered $event)
    {
        $msg_data = '恭喜您注册成功！';
        $to = objArr($event->eloquent);
        $data = ['msg_data' => $msg_data,'name' => $to['nickname']];//传给view文件的变量
        $subject = '恭喜您注册成功！';
        Mail::send(
            'emails.test',//view下的blade文件用来显示邮件内容
            $data,
            function ($message) use($to, $subject) {//用来配置收件人地址和邮件名称
                $message->to($to['email'],$to['nickname'])->subject($subject);
            }
        );
        if( Mail::failures()){//监听是否发送成功
            echo '邮件发送失败';
        }
    }
    /**
     * 任务应该发送到的队列的连接的名称
     *
     * @var string|null
     */
//    public $connection = 'sqs';

    /**
     * 任务应该发送到的队列的名称
     *
     * @var string|null
     */
//    public $queue = 'listeners';
    /**
     * 处理失败队列
     */
    public function failed(UserRegistered $event, $exception)
    {
        //
    }
}
