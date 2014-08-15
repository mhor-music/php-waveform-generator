<?php

namespace Test\WaveformGenerator\Configuration;
use PHPUnit_Framework_TestCase;
use WaveformGenerator\Configuration\WaveformConfiguration;

/**
 * Class WaveformConfigurationTest
 * @package Test\WaveformGenerator\Configuration
 */
class WaveformConfigurationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $defaultOptions = array(
        'temp_dir' => "/tmp",
        'height' => "100",
        'width' => "500",
        'foreground_color' => "#0076B9",
        'background_color' => "#68ADE0",
        'stereo' => false,
        'png' => false,
        'svg' => false,
        'configuration' => null,
        'help' => false,
        'quiet' => false,
        'verbose' => false,
        'version' => false,
        'ansi' => false,
        'no-ansi' => false,
        'no-interaction' => false,
    );

    /**
     * @var array
     */
    private $overideOptions = array(
        'temp_dir' => "/tmp",
        'height' => "100",
        'width' => "500",
        'foreground_color' => "#0076B9",
        'background_color' => "#68ADE0",
        'stereo' => false,
        'png' => false,
        'svg' => false,
        'configuration' => "/../../../fixtures/config.yml",
        'help' => false,
        'quiet' => false,
        'verbose' => false,
        'version' => false,
        'ansi' => false,
        'no-ansi' => false,
        'no-interaction' => false,
    );

    /**
     * @var array
     */
    private $overideMalformedOptions = array(
        'temp_dir' => "/tmp",
        'height' => "100",
        'width' => "500",
        'foreground_color' => "#0076B9",
        'background_color' => "#68ADE0",
        'stereo' => false,
        'png' => false,
        'svg' => false,
        'configuration' => "/../../../fixtures/configMalformed.yml",
        'help' => false,
        'quiet' => false,
        'verbose' => false,
        'version' => false,
        'ansi' => false,
        'no-ansi' => false,
        'no-interaction' => false,
    );

    public function testWithDefaultOptions()
    {
        $waveformConf = new WaveformConfiguration($this->defaultOptions);
        $this->assertEquals(100, $waveformConf->getHeight());
        $this->assertEquals(500, $waveformConf->getWidth());
        $this->assertEquals("#0076B9", $waveformConf->getForegroundColor());
        $this->assertEquals("#68ADE0", $waveformConf->getBackgroundColor());
        $this->assertEquals("10", $waveformConf->getQuality());
    }

    public function testOverideDefaultConfiguration()
    {
        $this->overideOptions['configuration'] = __DIR__ . $this->overideOptions['configuration'];
        $waveformConf = new WaveformConfiguration($this->overideOptions);
        $this->assertEquals(101, $waveformConf->getHeight());
        $this->assertEquals(501, $waveformConf->getWidth());
        $this->assertEquals("#0076B1", $waveformConf->getForegroundColor());
        $this->assertEquals("#68ADE1", $waveformConf->getBackgroundColor());
        $this->assertEquals("11", $waveformConf->getQuality());
    }

    /**
     * @expectedException \Symfony\Component\Yaml\Exception\ParseException
     */
    public function testWithMalformedOverideConfigDefaultConfiguration()
    {
        $this->overideMalformedOptions['configuration'] = __DIR__ . $this->overideMalformedOptions['configuration'];
        new WaveformConfiguration($this->overideMalformedOptions);
    }
}
