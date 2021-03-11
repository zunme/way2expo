<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Meeting;
use App\Models\Company;
use App\Models\User;
use App\Models\Notification;

class MeetingUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $log;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Meeting $meeting)
    {
        if( $meeting->meeting_status =='R'){
            return;
        }
        $msg = [
        "icon"=> $meeting->meeting_status=='A' ? "videos_call": "missed_videos_call",
        "title"=>"1:1 미팅",
        "target"=>$meeting->meeting_status=='A' ? "meeting.accept": "meeting.deny",
        "content"=> $meeting->meeting_status=='A' ? "미팅요청이 승인되었습니다.": "미팅요청이 거부되었습니다.",
        ];
        $company = Company::where('id', $meeting->company_id )->first();
        $noti = [
        'reciever_id'=>$meeting->user_id,
        'sender_id'=>$company->company_master_user_id,
        'data'=>$msg
        ];
        Notification::create($noti);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');
        return [];
    }
}
