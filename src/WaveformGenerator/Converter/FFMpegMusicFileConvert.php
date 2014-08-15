<?php

namespace WaveformGenerator\Converter;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Wav;
use FFMpeg\Media\Audio;

/**
 * Class FFMpegMusicFileConvert
 * @package WaveformGenerator\Converter
 */
class FFMpegMusicFileConvert
{
    /**
     * @var FFMpeg
     */
    protected $ffmpeg;

    /**
     * @var Audio
     */
    protected $audio;

    /**
     * @param $originalFilePath
     * @param array $configuration
     */
    public function __construct($originalFilePath, $configuration = array())
    {
        $this->ffmpeg = FFMpeg::create($configuration);
        $this->audio = $this->ffmpeg->open($originalFilePath);
    }

    /**
     * @return string
     */
    public function convert()
    {
        $format = new Wav();
        $format
            ->setAudioChannels(1)
            ->setAudioKiloBitrate(16)
        ;

        $tmpFile = sys_get_temp_dir() . '/' . uniqid() . '.wav';
        $this->audio->save($format, $tmpFile);

        return $tmpFile;
    }
}
