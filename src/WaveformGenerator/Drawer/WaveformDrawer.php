<?php

namespace WaveformGenerator\Drawer;

use WaveformGenerator\Configuration\WaveformConfiguration;
use WaveformGenerator\Reader\WavReader;

/**
 * Class WaveformDrawer
 * @package WaveformGenerator\Drawer
 */
class WaveformDrawer
{
    /**
     * @var WaveformConfiguration
     */
    protected $waveformConfiguration;

    /**
     * @var WavReader
     */
    protected $wavReader;

    /**
     * @var resource
     */
    protected $image;

    /**
     * @param WaveformConfiguration $waveformConfiguration
     * @param WavReader             $wavReader
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
     * @param  string $input
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
