<?php

namespace Foxws\MediaUtils\Conversions;

use FFMpeg\FFMpeg;
use Illuminate\Support\Fluent;
use Spatie\TemporaryDirectory\TemporaryDirectory;

abstract class Conversion extends Fluent
{
    abstract public function convert(string $file): self;

    protected function ffmpeg(): FFMpeg
    {
        return FFMpeg::create([
            'ffmpeg.binaries' => config('media-utils.ffmpeg.binaries'),
            'ffprobe.binaries' => config('media-utils.ffprobe.binaries'),
            'timeout' => config('media-utils.timeout', 3600),
            'ffmpeg.threads' => config('media-utils.ffmpeg.threads', 12),
            'temporary_directory' => config('media-utils.temporary_directory'),
        ]);
    }

    protected function temporaryDirectory(): TemporaryDirectory
    {
        return (new TemporaryDirectory())->create();
    }
}
