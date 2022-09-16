<?php

namespace Foxws\MediaUtils\Services;

use FFMpeg\FFProbe;

class FFProbeService
{
    public static function create(): FFProbe
    {
        return FFProbe::create([
            'ffprobe.binaries' => config('media-utils.ffprobe.binaries'),
            'temporary_directory' => config('media-utils.temporary_directory'),
        ]);
    }
}
