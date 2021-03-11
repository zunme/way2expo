<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @method static create(array $array)
 * @method static where(string $string, $booth_id)
 */
class BoothTag extends Model
{
    use HasFactory;
    protected $table = 'booth_tags';
    protected $fillable = [
        'booth_id',
        'name'
    ];

}
