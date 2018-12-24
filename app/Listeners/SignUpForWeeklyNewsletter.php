<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SignUpForWeeklyNewsletter
{
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
        // Sign user up for weekly newsletter
//        Newsletter::subscribe($event->user->email, ['FNAME': $event->user->fname, 'LNAME': $event->user->lname], 'SiteName Weekly');
    }
}
