<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use HasFactory;

    protected $table = 'user_metas';
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'agree_service', 'agree_marketing', 'gender', 'area', 'age', 'birthdate',
        'category_pid1', 'category_id1', 'category_pid2', 'category_id2', 'category_pid3', 'category_id3',
        'purpose_viewing', 'industry', 'company_name', 'company_dept', 'company_position', 'company_image_url', 'company_site',
        'company_tel', 'company_zip', 'company_address1', 'company_address2', 'intro', 'company_attachment_file_url',
        'company_attachment_file_name'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

}
