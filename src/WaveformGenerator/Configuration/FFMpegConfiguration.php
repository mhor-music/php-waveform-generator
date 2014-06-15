<?php

namespace WaveformGenerator\Configuration;

/**
 * Class Configuration
 * @package WaveformGenerator\Configuration
 */
class FFMpegConfiguration
{
    /**
     * @var string
     */
    protected $ffmpegPath;

    /**
     * @var bool
     */
    protected $isInstalled;

    /**
     * @param bool $isInstalled
     * @param $ffmpegPath
     */
    public function __construct($isInstalled = true, $ffmpegPath = null)
    {
        if ($isInstalled === false) {
            $this->isInstalled = false;
            $this->ffmpegPath = $ffmpegPath;
        }
    }

    /**
     * @return bool
     */
    public function check()
    {
        return true;
    }
}
