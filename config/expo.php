<?php

return [
  'email' =>env('MAIL_FROM_ADDRESS', 'support@way2expo.com') ,
  'kakaokey' =>'e1e0c8cd1b6f4167551210b0d77056c6',
  'default_image' =>'/image/bg-logo-poster.png',
  'mobile'=>[
    'expo_title_size' =>'',//sm , lg, default
    'expo_title_filter'=>'logocolor4',//gray, lightgray, logocolor1~4
    'banner' =>[
      'perview'=>[
        'header'=>'1',
        'footer'=>'1.1'
      ],
      'space'=>[
        'header'=> '0',
        'footer'=>'10'
      ],
      'arrow'=>[
        'header'=> 'off',
        'footer'=>'off'
      ],
    ],
    'notiroute'=>[
      'meeting.receive'=>"/m/meeting/receive",
      'meeting.send'=>"/m/meeting/send",
      'card.receive'=>"/mobile/cardlist",
      'meeting.accept'=>"/m/meeting/send",
      'meeting.deny'=>"/m/meeting/send",
    ],
  ],
  'desktop'=>[
    'expo_title_size' =>'',//sm , lg, default
    'expo_title_filter'=>'logocolor4',//gray, lightgray, logocolor1~4
    'banner' =>[
      'perview'=>[
        'header'=>'1',
        'footer'=>'1.1'
      ],
      'space'=>[
        'header'=> '0',
        'footer'=>'10'
      ],
      'arrow'=>[
        'header'=> 'on',
        'footer'=>'on'
      ],
      'indicators'=>[
        'header'=> 'on',
        'footer'=>'on'
      ],

    ],
    'notiroute'=>[
      'meeting.receive'=>"/m/meeting/receive",
      'meeting.send'=>"/m/meeting/send"
    ],
  ],
  'live_start_time' => '10:00',
  'live_end_time' => '17:00'
];
