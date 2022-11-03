<?php

namespace Foxws\MediaUtils\Conversions\Conversion;

use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;
use FFMpeg\Media\Video;
use Foxws\MediaUtils\Conversions\Conversion;
use Illuminate\Support\Collection;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class PreviewConversion extends Conversion
{
    public function convert(string $file): self
    {
        $tmp = $this->temporaryDirectory();

        $this->file = $file;

        $this->path = $tmp->path('preview.mp4');

        $this->performConversion($tmp);

        return $this;
    }

    protected function performConversion(TemporaryDirectory $tmp): void
    {
        $ffmpeg = $this->ffmpeg();

        $video = $ffmpeg->open($this->file);

        throw_if(! $video instanceof Video);

        $duration = $ffmpeg->getFFProbe()->format($this->file)->get('duration');

        $segments = $this->segments($duration);

        $clips = $segments->map(fn (float $segment) => $this->clip($video, $segment, $tmp));

        $video
            ->concat($clips->all())
            ->saveFromSameCodecs($this->path, true);
    }

    protected function clip(Video $video, float $segment, TemporaryDirectory $tmp): string
    {
        $path = $tmp->path("clip_{$segment}.mp4");

        $format = (new X264())
            ->setKiloBitrate(config('media-utils.preview.bitrate'))
            ->setAudioCodec('copy')
            ->setAdditionalParameters(['-an']);

        $clip = $video->clip(
            TimeCode::fromSeconds($segment),
            TimeCode::fromSeconds(config('media-utils.preview.duration'))
        );

        $clip->filters()->resize(
            dimension: new Dimension(config('media-utils.preview.width'), config('media-utils.preview.height')),
            mode: ResizeFilter::RESIZEMODE_INSET,
            forceStandards: true
        );

        $clip->save($format, $path);

        return $path;
    }

    protected function segments(float $duration = 0): Collection
    {
        $amount = config('media-utils.preview.amount');

        $collect = collect(range(0, $duration, $duration / ($amount + 1)))
            ->map(fn (float $segment) => floor($segment));

        $collect->shift();
        $collect->pop();

        return $collect;
    }
}
