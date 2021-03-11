<?php
return [
    //'serviceId' => '1d41f14c-53ad-42bc-baf0-eea8f533b592',
    //'key' => '468c5a1d0a385f811050956575587dcf7733c612e947dbe3455f7f7b8f01e3df',
	'serviceId' => 'bbb1972b-498f-4d71-b0c3-60644fc27dec',
    'key' => '3f2d05e1d964aafbab5e4ebd9055b62cb11fe132bf1660d3d357d321dc57f612',
	
    'masterToken' => '5f8a58e57f757260d2d6c247c7bb91675747fdeedc393b2431006efa15917c42',
    'wsurl' => 'wss://signal.remotemonster.com/ws',
    'resturl' => 'https://signal.remotemonster.com/rest',
    'lambdaurl' => 'https://signal.remotemonster.com/lambda',
    'username' => 'develop@way2expo.com',
    'media' => [
        'video' => [
            'defaultWidth' => '1280',
            'defaultHeight' => '720',
            'width' => [
                'max' => '1280',
                'min' => '480'
            ],
            'height' => [
                'max' => '1280',
                'min' => '480'
            ],
            'codec' => 'vp8',
            'maxBandwidth' => '3000',
            'frameRate' => [
                'default' => 30,
                'max' => 30,
                'min' => 25,
                ],
        ],
        'audio' => [
            'channelCount' => 2,
            'maxBandwidth' => 128,
            'autoGainControl' => 'false',
            'echoCancellation' => 'false',
            'noiseSuppression' => 'false',
        ]
    ],
    'rtc' => [
        'simulcast' => 'true',
        'audioType' => 'voice',

    ],
    'dev' => [
        'logLevel' => 'SILENT',//SILENT, ERROR, WARN, INFO, DEBUG, VERBOSE
    ],
    'timeOutForDays' => 7200
];
