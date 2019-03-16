<?php

namespace App\Listeners;

use App\Events\AppointmentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class OrderNotice implements ShouldQueue
{
    use InteractsWithQueue;
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
     * @param  AppointmentCreated  $event
     * @return void
     */
    public function handle(AppointmentCreated $event)
    {
        Redis::set('appointment_order_notice', '1');
    }
}
