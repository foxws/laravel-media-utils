<?php

namespace Foxws\MediaUtils\Services;

use FFMpeg\FFProbe\DataMapping\Format;
use FFMpeg\FFProbe\DataMapping\Stream;
use FFMpeg\FFProbe\DataMapping\StreamCollection;

class MediaMetadataService
{
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

    public function getFirstAudio(string $path): ?Stream
    {
        return $this->getSteams($path)->audios()->first();
    }

    public function getFirstVideo(string $path): ?Stream
    {
        return $this->getSteams($path)->videos()->first();
    }

    public function isValid(string $path): bool
    {
        $ffprobe = FFProbeService::create();

        return $ffprobe->isValid($path);
    }
}
