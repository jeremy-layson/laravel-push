<?php
return [

    'arn'   => [
        'ios_arn'           => env('AWS_SNS_IOS_ARN',       ''),
        'android_arn'       => env('AWS_SNS_ANDROID_ARN',   ''),
    ],

    'default'  => [
        'title'     => env('PUSH_DEFAULT_TITLE',    'Jeremy\'s Push Notification'), 
        'category'  => env('PUSH_DEFAULT_CATEGORY', 'default'),
    ]
];