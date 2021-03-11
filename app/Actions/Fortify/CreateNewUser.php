<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
      $messages = [
        'name.*'    => '이름(2~20자)을 입력해주세요.',
        'email.unique'=>'이미 사용중인 이메일입니다.',
        'email.*'=>'이메일을 확인해주세요.',
        'tel.required'    => '전화번호를 입력해주세요',
        'tel.*'    => '전화번호는 숫자, - 를 포함해 20자 이하로 적어주세요',
        'password.confirmed' =>"패스워드가 동일하지 않습니다.",
        //'password.*' =>"패스워드는 영문, 숫자, 특수문자(!, $, #, or % )를 이용해 4~20자로 적어주세요.",
        'password.*' =>"영문, 숫자를 포함한 6~20자 만 허용합니다.",
        'agree_email.*' =>"이메일 수신동의를 확인해주세요.",
        'agree_sms.*' =>"SMS 수신동의를 확인해주세요.",
    ];
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'tel' => 'required|min:2|regex:/^[0-9-]+$/|max:20',
            'agree_sms' => 'required|in:Y,N',
            'agree_email' => 'required|in:Y,N',
        ],$messages)->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'tel' => empty($input['tel']) ? '':$input['tel'],
            ]), function (User $user) {
                $this->createTeam($user);
            });
        });
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}
