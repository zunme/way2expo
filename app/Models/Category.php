<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'code1',
        'code2',
        'full_code',
        'name',
        'parent_id',
        'display_yn'
    ];

    public function scopeDisplay($query)
    {
        return $query->where('display_yn', 'Y');
    }

    public function childs()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->display();
    }
}
