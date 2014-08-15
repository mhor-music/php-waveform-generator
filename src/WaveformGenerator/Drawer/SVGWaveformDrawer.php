<?php

namespace WaveformGenerator\Drawer;

/**
 * Class SVGWaveformDrawer
 * @package WaveformGenerator\Drawer
 */
class SVGWaveformDrawer extends WaveformDrawer
{
    /**
     * @var string
     */
    protected $svg;

    /**
     * @var float
     */
    protected $yOffset;

    protected function writeHeader()
    {
        $this->svg  = "<?xml version=\"1.0\"?>\n";
        $this->svg .= "<svg width=\"100%\" height=\"100%\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\">\n";
        $this->svg .= "<rect width=\"100%\" height=\"100%\" />\n";

        $this->yOffset = floor(1 / 1 * $this->waveformConfiguration->getHeight());
    }

    protected function writeStyle()
    {
        list($br, $bg, $bb) = $this->html2rgb($this->waveformConfiguration->getBackgroundColor());
        list($r, $g, $b) = $this->html2rgb($this->waveformConfiguration->getForegroundColor());

        $this->svg .= '
            <style type="text/css" >
                <![CDATA[
                    rect {
                      fill: rgb(' . $br . ',' . $bg . ',' . $bb . ');
                    }
                    line {
                      stroke: rgb(' . $r . ',' . $g . ',' . $b . ');
                      stroke-width: 1px;
                    }
                ]]>
            </style>
        ';
    }

    protected function drawBackground()
    {
        $this->svg .= "<svg y=\"0%\" width=\"100%\" height=\"100%\">";
    }

    protected function drawDatas()
    {
        foreach ($this->wavReader->getData() as $point) {
            $x1 = $x2 = number_format($point->getDataPoint() / $this->wavReader->getDataSize() * 100, 2);
            $y1 = number_format($point->getData() / 255 * 100, 2);
            $y2 = 100 - $y1;
            if ($y1 != $y2) {
                $this->svg .= "<line x1=\"" . $x1. "%\" y1=\"" . $y1 . "%\" x2=\"" . $x2 . "%\" y2=\"" . $y2 . "%\" />\n";
            }
        }
    }

    protected function writeFooter()
    {
        $this->svg .= "\n</svg>\n</svg>";
    }

    public function save()
    {
        file_put_contents($this->waveformConfiguration->getWaveformFile() . '.svg', $this->svg);
    }

    public function draw()
    {
        $this->writeHeader();
        $this->writeStyle();
        $this->drawBackground();
        $this->drawDatas();
        $this->writeFooter();
    }

}
