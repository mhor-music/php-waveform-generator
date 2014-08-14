<?php

namespace WaveformGenerator\Reader;

/**
 * Class DataPoint
 * @package WaveformGenerator\Reader
 */
class DataPoint
{
    /**
     * @var integer
     */
    protected $data;

    /**
     * @var integer
     */
    protected $dataPoint;

    /**
     * @param integer $data
     * @param integer $dataPoint
     */
    public function __construct($data, $dataPoint)
    {
        $this->data = $data;
        $this->dataPoint = $dataPoint;
    }

    /**
     * @return integer
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return integer
     */
    public function getDataPoint()
    {
        return $this->dataPoint;
    }
}
