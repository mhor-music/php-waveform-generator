<?php

namespace WaveformGenerator\Converter;

use WaveformGenerator\Configuration\FFMpegConfiguration;

/**
 * Class FFMpegMusicFileConvert
 * @package WaveformGenerator\Converter
 */
class FFMpegMusicFileConvert
{
    /**
     * @var string
     */
    protected $originalFilePath;

    /**
     * @var string
     */
    protected $convertedFilePath;

    /**
     * @var string
     */
    protected $programName = 'ffmpeg';

    /**
     * @var \WaveformGenerator\Configuration\FFMpegConfiguration
     */
    protected $configuration;

    protected $availableExtensions = array(
        'mp3',
        'flac',
        'ogg',
        'wma'
    );

    /**
     * @var array
     */
    protected $options = array('-i');

    /**
     * @param \WaveformGenerator\Configuration\FFMpegConfiguration $conf
     * @param string $originalFilePath
     */
    public function __construct(FFMpegConfiguration $conf, $originalFilePath)
    {
        $this->configuration = $conf;
        $this->originalFilePath = $originalFilePath;
    }

    /**
     * @return bool
     */
    public function checkExtension()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isWavFile()
    {
        return true;
    }

    /**
     * @return string
     */
    public function convert()
    {
        $this->convertedFilePath = uniqid() . '.wav';

        return $this->convertedFilePath;
    }
}
 