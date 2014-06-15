<?php

namespace WaveformGenerator\Configuration;

/**
 * Class WaveformConfiguration
 * @package WaveformGenerator\Configuration
 */
class WaveformConfiguration
{
    /**
     * @var int
     */
    protected $height = 100;

    /**
     * @var int
     */
    protected $width = 500;

    /**
     * @var int
     */
    protected $quality = 300;

    /**
     * @var string
     */
    protected $backgroundColor = '#68ADE0';

    /**
     * @var string
     */
    protected $foregroundColor = '#0076B9';

    /**
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * @return string
     */
    public function getForegroundColor()
    {
        return $this->foregroundColor;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }
}
 