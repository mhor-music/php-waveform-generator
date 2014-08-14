<?php

namespace WaveformGenerator\Drawer;

/**
 * Class PNGWaveformDrawer
 * @package WaveformGenerator\WaveformDrawer
 */
class PNGWaveformDrawer extends WaveformDrawer
{
    protected function drawBackground()
    {
        if ($this->waveformConfiguration->getBackgroundColor() == "") {
            imagesavealpha($this->image, true);
            $transparentColor = imagecolorallocatealpha($this->image, 0, 0, 0, 127);
            imagefill($this->image, 0, 0, $transparentColor);
        } else {
            list($br, $bg, $bb) = $this->html2rgb($this->waveformConfiguration->getBackgroundColor());
            imagefilledrectangle(
                $this->image,
                0,
                0,
                (int) ($this->wavReader->getDataSize() / $this->waveformConfiguration->getQuality()),
                $this->waveformConfiguration->getHeight(),
                imagecolorallocate($this->image, $br, $bg, $bb)
            );
        }
    }

    protected function createImage()
    {
        $this->image = imagecreatetruecolor(
            $this->wavReader->getDataSize() / $this->waveformConfiguration->getQuality(),
            $this->waveformConfiguration->getHeight()
        );
    }

    protected function drawDatas()
    {
        list($r, $g, $b) = $this->html2rgb($this->waveformConfiguration->getForegroundColor());

        foreach ($this->wavReader->getData() as $point) {

            $v = (int) ($point->getData() / 255 * $this->waveformConfiguration->getHeight());
            if (!($v / $this->waveformConfiguration->getHeight() == 0.5)) {
                imageline(
                    $this->image,
                    (int) ($point->getDataPoint() / $this->waveformConfiguration->getQuality()),
                    $this->waveformConfiguration->getHeight() * 1 - $v,
                    (int) ($point->getDataPoint() / $this->waveformConfiguration->getQuality()),
                    $this->waveformConfiguration->getHeight() * 1 - ($this->waveformConfiguration->getHeight() - $v),
                    imagecolorallocate($this->image, $r, $g, $b)
                );
            }
        }
    }

    public function save()
    {
        imagepng($this->image, $this->waveformConfiguration->getWaveformFile() . '.png');
        imagedestroy($this->image);
    }

    public function draw()
    {
        $this->createImage();
        $this->drawBackground();
        $this->drawDatas();
    }
}
