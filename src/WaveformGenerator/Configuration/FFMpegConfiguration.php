<?php

namespace WaveformGenerator\Configuration;
use Symfony\Component\Process\Exception\RuntimeException;

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
    public function __construct($isInstalled = true,  $ffmpegPath)
    {
        if ($isInstalled === false) {
            $this->isInstalled = false;
            $this->ffmpegPath = $ffmpegPath;
        }

        if ($this->check() === false) {
            new RuntimeException("ffmpeg is not rightly configured");
        }
    }

    /**
     * @return bool
     */
    private function check()
    {
        return true;
    }
}
 