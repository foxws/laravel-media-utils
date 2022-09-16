<?php

namespace Foxws\MediaUtils\Services;

use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Filters\Video\ClipFilter;
use FFMpeg\Media\Video;
use Foxws\MediaUtils\Conversions\Conversion;
use Illuminate\Support\Collection;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class MediaPreviewService
{
    public function __construct(
        protected MediaMetadataService $mediaMetadataService,
    ) {
    }

    public function create(Conversion $conversion): string
    {
        $duration = $this->mediaMetadataService->getDuration($conversion->path);

        $segments = $this->getSegments($duration);

        $temporaryDirectory = (new TemporaryDirectory())->create();

        $clips = collect($segments)->map(function (float $segment) use ($conversion, $temporaryDirectory) {
            $destination = $temporaryDirectory->path("clip_{$segment}.mp4");

            $this->writeClip($conversion->path, $destination, $segment);

            return $destination;
        });

        return $this->concatClips($conversion->path, $temporaryDirectory, $clips);
    }

    protected function concatClips(
        string $path,
        TemporaryDirectory $temporaryDirectory,
        Collection $clips,
    ): string
    {
        $destination = $temporaryDirectory->path('preview.mp4');

        $ffmpeg = FFMpegService::create();

        $video = $ffmpeg->open($path);

        $video
            ->concat($clips->toArray())
            ->saveFromSameCodecs($destination, true);

        return $destination;
    }

    protected function writeClip(
        string $path,
        string $destination,
        float $start,
    ): Video {
        $ffmpeg = FFMpegService::create();

        $format = FFMpegService::vaapiFormat();

        $format
            ->setAdditionalParameters(config('media-utils.preview.parameters'))
            ->setKiloBitrate(config('media-utils.preview.bitrate'));

        $video = $ffmpeg->open($path);

        $clip = $video
            ->addFilter(new ClipFilter(
                TimeCode::fromSeconds($start),
                TimeCode::fromSeconds(config('media-utils.preview.duration'))
            ));

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
}
