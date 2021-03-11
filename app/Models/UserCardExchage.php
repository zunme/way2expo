<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCardExchage extends Model
{
    use HasFactory;
    protected $table = 'user_card_exchages';
    protected $fillable = ['user_id','company_id','booth_id','message','use_yn_sender','use_yn_company','read_yn','created_at'];

    public function cardSender()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
    public function companyInfo()
    {
        return $this->hasOne(Company::class, 'id','company_id');
    }
    public function boothInfo()
    {
        return $this->hasOne(Booth::class, 'id','booth_id');
    }
}
