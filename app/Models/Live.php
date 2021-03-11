<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Live extends Model
{
    use HasFactory;

    protected $table = 'lives';

    protected $fillable = [
        'booth_id', 'channel_id', 'user_id', 'live_status', 'like_count', 'visitor_count', 'download_url', 'gid', 'path'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = ['full_channel_id', 'total_like_count', 'play_time_sec'];

    /**
     * 방송중인
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('live_status', 'O');
    }

    /**
     * 오늘 방송
     * @param $query
     * @return mixed
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * 방송 플레이 시간(초)
     * @return int
     */
    public function getPlayTimeSecAttribute()
    {
        $start = Carbon::parse($this->created_at);
        $end = Carbon::parse($this->updated_at);
        return $start->diffInRealSeconds($end);
    }

    /**
     * 채널 변환
     * @return string
     */
    public function getFullChannelIdAttribute()
    {
        return 'booth_' . $this->booth_id . '_' . $this->channel_id;
    }

    /**
     * 누적 좋아요
     * TODO: 시점과 상관없이 부스 통합 카운트?
     * @return int|mixed
     */
    public function getTotalLikeCountAttribute()
    {
        return (int)$this::where('booth_id', $this->booth_id)->sum('like_count');
    }

    /**
     * 좋아요 증가
     */
    public function addLikeCount()
    {
        $this->like_count = $this->like_count + 1;
        $this->save();
    }

    /**
     * 방문자수 증가
     */
    public function addVisitorCount()
    {
        $this->visitor_count = $this->visitor_count + 1;
        $this->save();
    }
}
