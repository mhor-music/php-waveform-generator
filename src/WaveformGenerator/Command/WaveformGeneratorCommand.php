<?php

namespace WaveformGenerator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WaveformGenerator\Configuration\FFMpegConfiguration;
use WaveformGenerator\Configuration\WaveformConfiguration;
use WaveformGenerator\Converter\FFMpegMusicFileConvert;
use WaveformGenerator\Reader\WavReader;
use WaveformGenerator\WaveformDrawer\PNGWaveformDrawer;
use WaveformGenerator\WaveformDrawer\SVGWaveformDrawer;

/**
 * Class WaveformGeneratorCommand
 * @package WaveformGenerator\Command
 */
class WaveformGeneratorCommand extends Command
{
    /**
     * @var array
     */
    protected $extensions = array('png', 'svg');

    protected function configure()
    {
        $this
            ->setName('waveform-generator')
            ->setDescription('generate waveform image from music file')
            ->addArgument(
                'path',
                InputArgument::OPTIONAL,
                'path of music file'
            )
            ->addOption(
                'temp-dir',
                'tmp',
                InputOption::VALUE_REQUIRED,
                'Where you near to store WAV file',
                sys_get_temp_dir()
            )
            ->addOption(
                'height',
                'h',
                InputOption::VALUE_REQUIRED,
                'Waveform height',
                '100'
            )
            ->addOption(
                'width',
                'w',
                InputOption::VALUE_REQUIRED,
                'Waveform width',
                '500'
            )
            ->addOption(
                'foreground-color',
                'fc',
                InputOption::VALUE_REQUIRED,
                'Waveform foreground color',
                '#FFFFFF'
            )
            ->addOption(
                'background-color',
                'bc',
                InputOption::VALUE_REQUIRED,
                'Waveform background color',
                '#000000'
            )
            ->addOption(
                'png',
                null,
                InputOption::VALUE_NONE,
                'Export waveform to PNG'
            )
            ->addOption(
                'svg',
                null,
                InputOption::VALUE_NONE,
                'Export waveform to SVG'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();
        if (!$fs->exists($input->getArgument('path'))) {
            throw new \Exception('File doesn\'t exist');
        }

        $file = $input->getArgument('path');

        $conf = new FFMpegConfiguration();
        $conf->check();

        $converter = new FFMpegMusicFileConvert($conf, $file);

        $remove = false;
        if (!$converter->isWavFile()) {
            $converter->checkExtension();
            $file = $converter->convert();
            $remove = true;
        }

        $waveformConf = new WaveformConfiguration();
        $waveReader = new WavReader($file);
        $waveReader->read();

        if ($input->getOption('png')) {
            $waveformDrawerPNG = new PNGWaveformDrawer($waveformConf, $waveReader);
            $waveformDrawerPNG->draw();
            $waveformDrawerPNG->save();
        }

        if ($input->getOption('svg')) {
            $waveformDrawerSVG = new SVGWaveformDrawer($waveformConf, $waveReader);
            $waveformDrawerSVG->draw();
            $waveformDrawerSVG->save();
        }

        if ($remove) {
            $fs->remove($file);
        }
    }
}
