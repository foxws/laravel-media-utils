<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Conversions Queue
    |--------------------------------------------------------------------------
    |
    | This controls the conversion queue.
    |
    */

    'connection' => null,

    'queue' => null,

    /*
    |--------------------------------------------------------------------------
    | Video Preview
    |--------------------------------------------------------------------------
    |
    | This controls the video preview conversion.
    |
    */

    'preview' => [
        'bitrate' => 1000,

        'amount' => 10,

        'duration' => 1,

        'parameters' => [
            '-vf', 'hwupload,scale_vaapi=w=320:h=240:format=nv12',
            '-an',
        ],
    ],
];
