<?php

namespace WaveformGenerator\Reader;

/**
 * Class DataPoint
 * @package WaveformGenerator\Reader
 */
class DataPoint
{
    /**
     * @var int
     */
    protected $data;

    /**
     * @var int
     */
    protected $dataPoint;

    public function __construct($data, $dataPoint)
    {
        $this->data = $data;
        $this->dataPoint = $dataPoint;
    }

    /**
     * @return int
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getDataPoint()
    {
        return $this->dataPoint;
    }
}
