<?php

namespace Foxws\MediaUtils\Services;

use FFMpeg\FFProbe\DataMapping\Format;
use FFMpeg\FFProbe\DataMapping\StreamCollection;

class MediaMetadataService
{
    public function getDuration(string $path): float
    {
        $format = $this->getFormat($path);

        return $format->get('duration', 0);
    }

    public function getFormat(string $path): Format
    {
        $ffprobe = FFProbeService::create();

        return $ffprobe->format($path);
    }

    public function getSteams(string $path): StreamCollection
    {
        $ffprobe = FFProbeService::create();

        return $ffprobe->streams($path);
    }

    public function isValid(string $path): bool
    {
        $ffprobe = FFProbeService::create();

        return $ffprobe->isValid($path);
    }
}
