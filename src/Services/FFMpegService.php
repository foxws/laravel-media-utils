<?php

namespace Foxws\MediaUtils\Services;

use FFMpeg\FFMpeg;

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
}
