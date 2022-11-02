<?php

namespace Foxws\MediaUtils\Services;

use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;
use FFMpeg\Media\Video;
use Illuminate\Support\Collection;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class MediaPreviewService
{
    public function __construct(
        protected MediaMetadataService $metadataService,
    ) {
    }

    public function create(string $path): string
    {
        $duration = $this->getDuration($path);

        $segments = $this->getSegments($duration);

        $tmp = (new TemporaryDirectory())->create();

        $clips = collect($segments)->map(function (float $segment) use ($path, $tmp) {
            $destination = $tmp->path("clip_{$segment}.mp4");

            $this->writeClip($path, $destination, $segment);

            return $destination;
        });

        return $this->concatClips($path, $tmp, $clips);
    }

    protected function concatClips(
        string $path,
        TemporaryDirectory $tmp,
        Collection $clips,
    ): string {
        $destination = $tmp->path('preview.mp4');

        $ffmpeg = FFMpegService::create();

        $video = $ffmpeg->open($path);

        $video
            ->concat($clips->all())
            ->saveFromSameCodecs($destination, true);

        return $destination;
    }

    protected function writeClip(
        string $path,
        string $destination,
        float $start,
    ): Video {
        $ffmpeg = FFMpegService::create();

        $video = $ffmpeg->open($path);

        $format = (new X264())
            ->setKiloBitrate(config('media-utils.preview.bitrate'))
            ->setAudioCodec('copy')
            ->setAdditionalParameters(['-an']);

        $clip = $video->clip(
            TimeCode::fromSeconds($start),
            TimeCode::fromSeconds(config('media-utils.preview.duration'))
        );

        $clip->filters()->resize(
            dimension: new Dimension(config('media-utils.preview.width'), config('media-utils.preview.height')),
            mode: ResizeFilter::RESIZEMODE_INSET,
            forceStandards: true
        );

        return $clip->save($format, $destination);
    }

    protected function getSegments(float $duration = 0): array
    {
        $amount = config('media-utils.preview.amount');

        $segments = array_map('floor', range(0, $duration, $duration / ($amount + 2)));

        // Remove first and last segment
        array_shift($segments);
        array_pop($segments);

        return $segments;
    }

    protected function getDuration(string $path): float
    {
        $format = $this->metadataService->getFormat($path);

        return $format->get('duration', 0);
    }
}
