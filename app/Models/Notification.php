<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\NotiEvent;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
                'reciever_id', 'sender_id', 'data', 'noti_read','noti_status'
              ];
    protected $casts = [
        'data' => 'array',
    ];
    protected $dispatchesEvents = [
      'created' => NotiEvent::class,
    ];
    public function newCount($user) {
      if( empty($user->id) ) return '0';
      return Notification::where('reciever_id', $user->id)
        ->where("noti_read",'N')->count();
    }
}
