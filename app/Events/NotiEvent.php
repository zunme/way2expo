<?php

namespace App\Events;
use App\Models\Notification;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotiEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $noti, $user;
    public function __construct(Notification $noti)
    {
        $this->noti = $noti;
        $this->user = $noti->reciever_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
       return [
        new PrivateChannel('admin.membernoti'),
        //new PrivateChannel('noti.'.$this->user)
        new PrivateChannel('noti.'.$this->user)
      ];
    }
    public function broadcastWith () {
        return [
          'id'=>$this->noti->id,
          'data'=>$this->noti->data ,
          'created_at'=>$this->noti->created_at->format('Y-m-d H:i:s'),//$this->noti->created_at->diffForHumans() ,
        ];
        //return ['id'       => 'test', ];
    }
}
