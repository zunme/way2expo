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
use App\Models\Booth;
use App\Models\User;
use App\Models\Notification;

class MeetingCreated
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
        $booth = Booth::where( 'id', $meeting->booth_id)->first();
        $company_id = $booth->company_id;
        if( $company_id > 0 ){

          $msg = [
            "icon"=>"more_time",
            "title"=>"미팅요청",
            "target"=>"meeting.receive",
            "content"=> $meeting->meeting_date." ".$meeting->meeting_time."시 미팅요청이 있습니다",
          ];
          $users = USER::where('company_id', $company_id)->get();
          foreach( $users as $user ){
            $noti = [
              'reciever_id'=>$user->id,
              'sender_id'=>$meeting->user_id,
              'data'=>$msg
            ];
            Notification::create($noti);
            //throw new \Exception('Exception message');
          }
			$beamsClient = new \Pusher\PushNotifications\PushNotifications(array(
			  "instanceId" => \Config::get('beam.id'),
			  "secretKey" => \Config::get('beam.key'),
			));
			$publishResponse = $beamsClient->publishToInterests(
			  array("company_".$booth->company_id),
			  array("web" => array("notification" => array(
				"title" => "미팅요청",
				"body" => $msg['content'],
				"deep_link" => url('/'),
			  )),
			));			
			
          $msg = [
            "icon"=>"more_time",
            "title"=>"미팅요청",
            "target"=>"meeting.send",
            "content"=> '['.$booth->booth_title.'] 부스에 '.$meeting->meeting_date." ".$meeting->meeting_time."시 미팅요청을 하였습니다.",
          ];
          $noti = [
            'reciever_id'=>$meeting->user_id,
            'sender_id'=>$meeting->user_id,
            'data'=>$msg
          ];
          Notification::create($noti);
        }
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
