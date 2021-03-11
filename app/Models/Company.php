<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $fillable = [
        'company_master_user_id'
        ,'company_name', 'company_tel1', 'company_tel2'
        ,'company_address1', 'company_address2', 'company_daum_place_id'
        ,'company_email', 'company_url'
        ,'company_display_status', 'company_level'
        ,'company_category1', 'company_image_url'
        ,'company_info1','company_info2','company_attachment_file_url1', 'company_attachment_file_url2','company_attachment_file_name1', 'company_attachment_file_name2'
        ,'company_name_eng'
        ,'company_zip'
        ,'company_attachment_file'
        ,'company_ceo_name'
        ,'company_ceo_email'
        ,'company_biz_no'
        ,'tax_manager_name'
        ,'tax_manager_email'
        ,'tax_manager_position'
        ,'tax_manager_tel'
        ,'tax_manager_phone'
        ,'tax_manager_fax'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDisplay($query){
        return $query->where('company_display_status', 'Y');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyMasterUser() {
        return $this->belongsTo("App\Models\User","company_master_user_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyBooth() {
        return $this->hasMany("App\Models\Booth","company_id");
    }

    /**
     * @return mixed
     */
    public function getmaster(){
        return $this->company_master_user_id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Responsibility() {
        return $this->hasMany("App\Models\User","company_id")
            ->where('users.user_status','Y')
            ;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getImageUrl()
    {
        return url(Storage::disk('public')
            ->url($this->company_image_url));
    }

    public function getFileUrl()
    {
        return url(Storage::disk('public')
            ->url($this->company_attachment_file_url1));
    }

}
