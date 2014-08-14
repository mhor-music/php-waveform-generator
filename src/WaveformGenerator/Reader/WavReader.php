<?php

namespace WaveformGenerator\Reader;

/**
 * Class WavReader
 * @package WaveformGenerator\Reader
 */
class WavReader
{
    /**
     * @var string
     */
    protected $wavFile;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $heading;

    /**
     * @var float|integer
     */
    protected $peek;

    /**
     * @var bool
     */
    protected $isStereo;

    /**
     * @var float|integer
     */
    protected $byte;

    /**
     * @var float|integer
     */
    protected $channel;

    /**
     * @var float|integer
     */
    protected $ratio;

    /**
     * @var resource
     */
    protected $handler;

    /**
     * @var integer
     */
    protected $dataPoint;

    /**
     * @var float
     */
    protected $dataSize;

    /**
     * @param string $file
     */
    public function __construct($file)
    {
        $this->wavFile = $file;
    }

    /**
     * @return float
     */
    public function getByte()
    {
        return $this->byte;
    }

    /**
     * @return integer
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return array
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

    /**
     * @return double
     */
    public function getDataSize()
    {
        return $this->dataSize;
    }

    /**
     * @return boolean
     */
    public function isIsStereo()
    {
        return $this->isStereo;
    }

    /**
     * @return string
     */
    public function getWavFile()
    {
        return $this->wavFile;
    }

    public function read()
    {
        $this->getHeader();
        $this->getBitrate();
        $this->getDataPoints();

        fclose($this->handler);
    }

    public function getHeader()
    {
        $this->handler = fopen($this->wavFile, "r");

        $this->heading[] = fread($this->handler, 4);
        $this->heading[] = bin2hex(fread($this->handler, 4));
        $this->heading[] = fread($this->handler, 4);
        $this->heading[] = fread($this->handler, 4);
        $this->heading[] = bin2hex(fread($this->handler, 4));
        $this->heading[] = bin2hex(fread($this->handler, 2));
        $this->heading[] = bin2hex(fread($this->handler, 2));
        $this->heading[] = bin2hex(fread($this->handler, 4));
        $this->heading[] = bin2hex(fread($this->handler, 4));
        $this->heading[] = bin2hex(fread($this->handler, 2));
        $this->heading[] = bin2hex(fread($this->handler, 2));
        $this->heading[] = fread($this->handler, 4);
        $this->heading[] = bin2hex(fread($this->handler, 4));
    }

    /**
     * @param $byte1
     * @param $byte2
     * @return double
     */
    protected function findValues($byte1, $byte2)
    {
        $byte1 = hexdec(bin2hex($byte1));
        $byte2 = hexdec(bin2hex($byte2));

        return ($byte1 + ($byte2 * 256));
    }

    protected function getBitrate()
    {
        $this->peek = hexdec(substr($this->heading[10], 0, 2));
        $this->byte = $this->peek / 8;
        $this->channel = hexdec(substr($this->heading[6], 0, 2));
        $this->ratio = ($this->channel == 2 ? 40 : 80);
        $this->dataSize = floor((filesize($this->wavFile) - 44) / ($this->ratio + $this->byte) + 1);
        $this->dataPoint = 0;
    }

    protected function getDataPoints()
    {
        while (!feof($this->handler) && $this->dataPoint < $this->dataSize) {
            if ($this->dataPoint++ % 5 == 0) {
                $bytes = array();
                for ($i = 0; $i < $this->byte; $i++) {
                    $bytes[$i] = fgetc($this->handler);
                }

                switch ($this->byte) {
                    case 1:
                        $this->data[] = new DataPoint(
                            $this->findValues($bytes[0], $bytes[1]),
                            $this->dataPoint
                        );
                        break;
                    case 2:
                        if (ord($bytes[1]) & 128) {
                            $temp = 0;
                        } else {
                            $temp = 128;
                        }
                        $temp = chr((ord($bytes[1]) & 127) + $temp);
                        $this->data[] = new DataPoint(
                            floor($this->findValues($bytes[0], $temp) / 256),
                            $this->dataPoint
                        );
                        break;
                }

                fseek($this->handler, $this->ratio, SEEK_CUR);

            } else {
                fseek($this->handler, $this->ratio + $this->byte, SEEK_CUR);
            }
        }
    }
}
