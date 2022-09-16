<?php

namespace Foxws\MediaUtils\Support\Format;

use FFMpeg\Format\Video\DefaultVideo;

class VAAPI extends DefaultVideo
{
    /** @var bool */
    private $bframesSupport = false;

    /** @var int */
    private $passes = 2;

    public function __construct($audioCodec = 'aac', $videoCodec = 'h264_vaapi')
    {
        $this
            ->setAudioCodec($audioCodec)
            ->setVideoCodec($videoCodec);
    }

    /**
     * {@inheritDoc}
     */
    public function supportBFrames()
    {
        return $this->bframesSupport;
    }

    /**
     * @param $support
     * @return VAAPI
     */
    public function setBFramesSupport($support)
    {
        $this->bframesSupport = $support;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAvailableAudioCodecs()
    {
        return ['copy', 'aac', 'libvo_aacenc', 'libfaac', 'libmp3lame', 'libfdk_aac', 'none'];
    }

    /**
     * {@inheritDoc}
     */
    public function getAvailableVideoCodecs()
    {
        return ['h264_vaapi'];
    }

    /**
     * @param $passes
     * @return VAAPI
     */
    public function setPasses($passes)
    {
        $this->passes = $passes;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPasses()
    {
        return $this->passes;
    }

    /**
     * @return int
     */
    public function getModulus()
    {
        return 2;
    }
}
