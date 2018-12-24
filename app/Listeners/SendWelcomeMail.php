<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMail implements ShouldQueue
{
    use InteractsWithQueue;//手动访问监听器下面队列任务的 delete 和 release 方法
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $msg_data = '测试邮件123ddd';
        $to = objArr($event->eloquent);
        $data = ['msg_data' => $msg_data];//传给view文件的变量
        $subject = '来自公司的测试邮件';
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
     * 处理失败队列
     */
    public function failed(UserRegistered $event, $exception)
    {
        //
    }
}
