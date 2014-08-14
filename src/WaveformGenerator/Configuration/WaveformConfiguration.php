<?php

namespace WaveformGenerator\Configuration;

/**
 * Class WaveformConfiguration
 * @package WaveformGenerator\Configuration
 */
class WaveformConfiguration
{
    /**
     * @var string
     */
    protected $waveformFile;

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
    protected $quality = 10;

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
     * @param  string $backgroundColor
     * @return WaveformConfiguration
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    /**
     * @return string
     */
    public function getForegroundColor()
    {
        return $this->foregroundColor;
    }

    /**
     * @param  string $foregroundColor
     * @return waveformconfiguration
     */
    public function setForegroundColor($foregroundColor)
    {
        $this->foregroundColor = $foregroundColor;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param  int $height
     * @return WaveformConfiguration
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param  int $quality
     * @return WaveformConfiguration
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * @return string
     */
    public function getWaveformFile()
    {
        return $this->waveformFile;
    }

    /**
     * @param  string $waveformFile
     * @return WaveformConfiguration
     */
    public function setWaveformFile($waveformFile)
    {
        $this->waveformFile = $waveformFile;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param  int $width
     * @return WaveformConfiguration
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }
}
