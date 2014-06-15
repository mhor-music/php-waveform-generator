<?php

namespace WaveformGenerator\Reader;

/**
 * Class WavReader
 * @package WaveformGenerator\Reader
 */
class WavReader
{
    /**
     * @var array
     */
    protected $heading;

    /**
     * @var float
     */
    protected $peek;

    /**
     * @var bool
     */
    protected $isStereo;

    /**
     * @var float
     */
    protected $byte;
}
 