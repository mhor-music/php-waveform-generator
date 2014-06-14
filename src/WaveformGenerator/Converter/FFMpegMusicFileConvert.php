<?php

namespace WaveformGenerator\Converter;

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
     * @param string $originalFilePath
     */
    public function __construct($originalFilePath)
    {
        $this->originalFilePath = $originalFilePath;
        return null;
    }

    /**
     * @return bool
     */
    public function checkExtension()
    {
        return true;
    }

    /**
     * @return string
     */
    public function convert()
    {
        return $this->convertedFilePath;
    }
}
 