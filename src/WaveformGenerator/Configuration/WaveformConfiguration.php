<?php

namespace WaveformGenerator\Configuration;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

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
     * @var integer
     */
    protected $height;

    /**
     * @var integer
     */
    protected $width;

    /**
     * @var integer
     */
    protected $quality = 10;

    /**
     * @var string
     */
    protected $backgroundColor;

    /**
     * @var string
     */
    protected $foregroundColor;

    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    public function __construct($options)
    {
        $configuration = $this->getParameters($options);
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->fill($configuration);
    }

    /**
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * @param  string                $backgroundColor
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
     * @param  string                $foregroundColor
     * @return waveformconfiguration
     */
    public function setForegroundColor($foregroundColor)
    {
        $this->foregroundColor = $foregroundColor;

        return $this;
    }

    /**
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param  integer               $height
     * @return WaveformConfiguration
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return integer
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param  integer               $quality
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
     * @param  string                $waveformFile
     * @return WaveformConfiguration
     */
    public function setWaveformFile($waveformFile)
    {
        $this->waveformFile = $waveformFile;

        return $this;
    }

    /**
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param  integer               $width
     * @return WaveformConfiguration
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @param  array $options
     * @return array
     */
    protected function getParameters($options)
    {
        $configuration = array();
        if ($options['configuration'] && file_exists($options['configuration'])) {
            $yaml = new Parser();
            try {
                $configuration = $yaml->parse(file_get_contents($options['configuration']));
            } catch (ParseException $e) {
                printf("Unable to parse the YAML string: %s", $e->getMessage());
            }
        }

        return array_merge($options, $configuration);
    }

    /**
     * @param array $configuration
     */
    protected function fill($configuration)
    {
        foreach ($configuration as $key => $value) {
            if ($this->accessor->isWritable($this, $key)) {
                $this->accessor->setValue($this, $key, $value);
            }
        }
    }
}
