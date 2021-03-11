<?php

namespace App\Providers\Kakao;

use SocialiteProviders\Kakao\KakaoProvider as BaseKakaoProvider;

class KakaoProvider extends BaseKakaoProvider
{
	protected function getUnlinkUrl(): string
    {
        return 'https://kapi.kakao.com/v1/user/unlink';
    }

	public function removeAccessTokenResponse( string $token ): void
    {
         $res = $this->getHttpClient()->request('POST', $this->getUnlinkUrl(), [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ],
        ]);
    }
	public function removeAccessTokenAdmin( string $id ): void
    {
		
		$res = $this->getHttpClient()->request('POST', $this->getUnlinkUrl(), [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "KakaoAK {$this->clientSecret}",
            ],
			'form_params' =>[
				'target_id_type'=>'user_id',
				'target_id'=>$id
			],
        ]);
		dump($res);
    }
}