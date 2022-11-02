<?php

return [
    /*
    |--------------------------------------------------------------------------
    | FFMpeg
    |--------------------------------------------------------------------------
    |
    | This controls the ffmpeg configuration.
    |
    */

    'ffmpeg' => [
        'binaries' => env('FFMPEG_BINARIES', 'ffmpeg'),

        'threads' => 12,
    ],

    /*
    |--------------------------------------------------------------------------
    | FFProbe
    |--------------------------------------------------------------------------
    |
    | This controls the ffprobe configuration.
    |
    */

    'ffprobe' => [
        'binaries' => env('FFPROBE_BINARIES', 'ffprobe'),
    ],

    /*
    |--------------------------------------------------------------------------
    | FFProbe
    |--------------------------------------------------------------------------
    |
    | This controls the ffmpeg timeout.
    |
    */
    'timeout' => 3600,

    /*
    |--------------------------------------------------------------------------
    | Temporary path
    |--------------------------------------------------------------------------
    |
    | This controls the temporary path.
    |
    */

    'temporary_directory' => env('FFMPEG_TEMPORARY_DIRECTORY', sys_get_temp_dir()),

    /*
    |--------------------------------------------------------------------------
    | Thumbnail
    |--------------------------------------------------------------------------
    |
    | This controls the thumbnail conversion.
    |
    */

    'thumbnail' => [
        'filename' => 'frame.jpg',

        'width' => 320,

        'height' => 240,
    ],

    /*
    |--------------------------------------------------------------------------
    | Video Preview
    |--------------------------------------------------------------------------
    |
    | This controls the video preview conversion.
    |
    */

    'preview' => [
        'bitrate' => 1500,

        'amount' => 10,

        'duration' => 1,

        'width' => 320,

        'height' => 240,
    ],
];
