<?php

return [
    'site_code' => env('CHECKPLUS_SITE_CODE'),
    'site_pw' => env('CHECKPLUS_SITE_PW'),
    'return_url' => env('APP_URL').'/checkplus/success',
    'error_url' => env('APP_URL').'/checkplus/fail',
    'mobile_return_url' => '',
    'mobile_error_url' => '',
    'err_code' => [
        '0000' => ' 인증 성공',
        '0001' => ' 인증 불일치(통신사선택오류, 생년월일/성명/휴대폰번호불일치, 휴대폰일시정지, 선불폰가입자, SMS발송실패, 인증문자불일치 등)',
        '0003' => ' 기타인증오류',
        '0010' => ' 인증번호 불일치(소켓)',
        '0012' => ' 요청정보오류(입력값오류)',
        '0013' => ' 암호화 시스템 오류',
        '0014' => ' 암호화 처리 오류',
        '0015' => ' 암호화 데이터 오류',
        '0016' => ' 복호화 처리 오류',
        '0017' => ' 복호화 데이터 오류',
        '0018' => ' 통신오류',
        '0019' => ' 데이터베이스 오류',
        '0020' => ' 유효하지않은 CP코드',
        '0021' => ' 중단된 CP코드',
        '0022' => ' 휴대전화본인확인 사용불가 CP코드',
        '0023' => ' 미등록 CP코드',
        '0031' => ' 유효한 인증이력 없음',
        '0035' => ' 기인증완료건(소켓)',
        '0040' => ' 본인확인차단고객(통신사)',
        '0041' => ' 인증문자발송차단고객(통신사)',
        '0050' => ' NICE 명의보호서비스 이용고객 차단',
        '0052' => ' 부정사용차단',
        '0070' => ' 간편인증앱 미설치',
        '0071' => ' 앱인증 미완료',
        '0072' => ' 간편인증 처리중 오류',
        '0073' => ' 간편인증앱 미설치(LG U+ Only)',
        '0074' => ' 간편인증앱 재설치필요',
        '0075' => ' 간편인증사용불가-스마트폰아님',
        '0076' => ' 간편인증앱 미설치',
        '0078' => ' 14세 미만 인증 오류',
        '0079' => ' 간편인증 시스템 오류',
        '9097' => ' 인증번호 3회 불일치',
    ],
];
