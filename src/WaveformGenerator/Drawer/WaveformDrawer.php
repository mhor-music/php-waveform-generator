<?php

namespace WaveformGenerator\WaveformDrawer;

use WaveformGenerator\Configuration\WaveformConfiguration;
use WaveformGenerator\Reader\WavReader;

/**
 * Class WaveformDrawer
 * @package WaveformGenerator\WaveformDrawer
 */
class WaveformDrawer
{
    /**
     * @var \WaveformGenerator\Configuration\WaveformConfiguration
     */
    protected $waveformConfiguration;

    /**
     * @var \WaveformGenerator\Reader\WavReader
     */
    protected $wavReader;

    /**
     * @param WaveformConfiguration $waveformConfiguration
     * @param WavReader $wavReader
     */
    public function __construct(WaveformConfiguration $waveformConfiguration, WavReader $wavReader)
    {
        $this->waveformConfiguration = $waveformConfiguration;
        $this->wavReader = $wavReader;
    }

    /**
     * @return bool
     */
    public function save()
    {
        return false;
    }

    /**
     * @param $input
     * @return array
     */
    protected function html2rgb($input)
    {
        $input = ($input[0] == "#") ? substr($input, 1, 6) : substr($input, 0, 6);
        return array(
            hexdec(substr($input, 0, 2)),
            hexdec(substr($input, 2, 2)),
            hexdec(substr($input, 4, 2))
        );
    }
}
 