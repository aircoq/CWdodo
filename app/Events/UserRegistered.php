<?php

namespace App\Events;

use App\Models\Admin\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eloquent;

    public function __construct(User $user)
    {
        $this->eloquent = $user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
