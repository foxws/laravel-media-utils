<?php

namespace Foxws\MediaUtils\Conversions\Conversion;

use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Media\Video;
use Foxws\MediaUtils\Conversions\Conversion;

class ThumbnailConversion extends Conversion
{
    public function convert(string $file): self
    {
        $tmp = $this->temporaryDirectory();

        $this->file = $file;

        $this->path = $tmp->path(config('media-utils.thumbnail.filename'));

        $this->performConversion();

        return $this;
    }

    protected function performConversion(): void
    {
        $ffmpeg = $this->ffmpeg();

        $video = $ffmpeg->open($this->file);

        throw_if(! $video instanceof Video);

        $duration = $ffmpeg->getFFProbe()->format($this->file)->get('duration', 0);

        $quantity = $this->frameAt ?? round($duration / 2);

        $video->filters()->resize(
            dimension: new Dimension(config('media-utils.thumbnail.width'), config('media-utils.thumbnail.height')),
            mode: ResizeFilter::RESIZEMODE_INSET,
            forceStandards: true
        );

        $video
            ->frame(TimeCode::fromSeconds($quantity))
            ->save($this->path);
    }

    public function extractFrameAt(float $seconds = 0): self
    {
        $this->frameAt = $seconds;

        return $this;
    }
}
