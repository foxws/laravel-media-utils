<?php

namespace Foxws\MediaUtils\Conversions\Conversion;

use Foxws\MediaUtils\Conversions\Conversion;

class MetadataConversion extends Conversion
{
    public function convert(string $file): self
    {
        $ffprobe = $this->ffmpeg()->getFFProbe();

        $this->format = $ffprobe->format($file);

        $this->streams = $ffprobe->streams($file);

        return $this;
    }
}
