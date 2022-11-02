<?php

namespace Foxws\MediaUtils\Services;

use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Filters\Video\ResizeFilter;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class MediaThumbnailService
{
    public function __construct(
        protected MediaMetadataService $metadataService,
    ) {
    }

    public function create(string $path, ?float $at = null): string
    {
        $at ??= round($this->getDuration($path) / 2);

        $destination = $this->getDestination();

        $ffmpeg = FFMpegService::create();

        $video = $ffmpeg->open($path);

        $video->filters()->resize(
            dimension: new Dimension(config('media-utils.thumbnail.width'), config('media-utils.thumbnail.height')),
            mode: ResizeFilter::RESIZEMODE_INSET,
            forceStandards: true
        );

        $video
            ->frame(TimeCode::fromSeconds($at))
            ->save($destination);

        return $destination;
    }

    protected function getDuration(string $path): float
    {
        $format = $this->metadataService->getFormat($path);

        return $format->get('duration', 0);
    }

    protected function getDestination(): string
    {
        return (new TemporaryDirectory())
            ->create()
            ->path(config('media-utils.thumbnail.filename'));
    }
}
