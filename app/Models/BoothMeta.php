<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoothMeta extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'booth_metas';
    protected $primaryKey = 'booth_id';
    protected $fillable = ['booth_id', 'visitor_count', 'product_count', 'product_in_cart_count', 'favorite_count', 'meeting_count', 'live_comment_count', 'live_like_count'];

    function addViewCount()
    {
        $this->visitor_count = $this->visitor_count + 1;
        $this->save();
    }

    function addFavoriteCount()
    {
        $this->favorite_count = $this->favorite_count + 1;
        $this->save();
    }

    function addMeetingCount()
    {
        $this->meeting_count = $this->meeting_count + 1;
        $this->save();
    }

}
