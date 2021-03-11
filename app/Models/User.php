<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * @method static create(array $input)
 * @method static where(string $string, $user_id)
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'kakao_id',
		'di',
        'name',
        'email',
        'tel',
        'business_card_front',
        'business_card_back',
        'country_id',
        'company_id',
        'agree_email',
        'agree_sms',
        'user_status',
        'email_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
		'kakao_id',
		'di',
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    /**
     * 회사 마스터 사용자
     * @return HasMany
     */
    public function companyMasterUser_() {
        return $this->hasMany("App\Models\Company",'company_master_user_id');
    }
    public function card() {
        return $this->hasOne("App\Models\UserCard");
    }
    public function company() {
        return $this->hasOne("App\Models\Company", 'id', 'company_id');
    }
    public function meta() {
        return $this->hasOne("App\Models\UserMeta");
    }
    /**
     * 이미지 업로드
     * @param $col
     * @param UploadedFile|null $file
     */
    public function saveImage($col, UploadedFile $file = null){
      $this->deleteImage($col);
      $image = Image::make($file);

      $image_name = Carbon::now()->timestamp.'_'.( Str::random(8) ).'.'. mimeToExt( $image->mime) ;

      Storage::disk('public')->put('users/'. $image_name, $image->stream()->__toString());

      $this->update([
          $col => 'users/'.$image_name
      ]);
    }

    /**
     * 이미지 제거
     * @param $col
     */
    private function deleteImage($col){
        $storage = Storage::disk('public');
        $image_path = $this->{$col};
        if($storage->exists($image_path) && $image_path !== null){
            $storage->delete($image_path);
        }
    }

}
