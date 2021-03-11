<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryForm extends Model
{
    use HasFactory;

    protected $table = 'entry_forms';

    protected $fillable = [
        'expo_id',
        'user_id',
        'status',
        'agree_privacy',
        'agree_entry',
        'agree_provided',
        'category_text',
        'category_detail_text',
        'company_name',
        'company_name_eng',
        'company_zip',
        'company_address1',
        'company_address2',
        'company_url',
        'biz_no',
        'ceo_name',
        'ceo_email',
        'manager_name',
        'manager_email',
        'manager_position',
        'manager_tel',
        'manager_phone',
        'manager_fax',
        'tax_manager_name',
        'tax_manager_email',
        'tax_manager_position',
        'tax_manager_tel',
        'tax_manager_phone',
        'tax_manager_fax',
        'attachment_file_url',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function expo()
    {
        return $this->belongsTo("App\Models\Expo", "expo_id");
    }
}
