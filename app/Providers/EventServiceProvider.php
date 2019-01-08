<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        'App\Events\Event' => [
//            'App\Listeners\EventListener',
//        ],
        'App\Events\UserRegistered' => [
            'App\Listeners\SendWelcomeMail',
        ],
        'App\Events\AppointmentCreated' => [//预约成功后
            'App\Listeners\SendNotice',//新增预约订单提醒记录到rides队列（发送通知到商家）
        ],
    ];

    /**
     * 需要注册的订阅者类。
     *
     * @var array
     */
    protected $subscribe = [
//        'App\Listeners\SignUpForWeeklyNewsletter',
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
