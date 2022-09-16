<?php

namespace Foxws\MediaUtils\Services;

use FFMpeg\FFMpeg;
use Foxws\MediaUtils\Support\Format\VAAPI;

class FFMpegService
{
    public static function create(): FFMpeg
    {
        return FFMpeg::create([
            'ffmpeg.binaries' => config('media-utils.ffmpeg.binaries'),
            'ffprobe.binaries' => config('media-utils.ffprobe.binaries'),
            'timeout' => config('media-utils.timeout', 3600),
            'ffmpeg.threads' => config('media-utils.ffmpeg.threads', 12),
            'temporary_directory' => config('media-utils.temporary_directory'),
        ]);
    }

    public static function vaapiFormat(): VAAPI
    {
        $format = new VAAPI();

        $format->setInitialParameters([
            '-hwaccel', config('media-utils.hwaccel', 'vaapi'),
            '-hwaccel_device', config('media-utils.hwaccel_device', '/dev/dri/renderD128'),
            '-hwaccel_output_format', config('media-utils.hwaccel_output_format', 'vaapi'),
        ]);

        return $format;
    }
}
