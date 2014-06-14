<?php

namespace WaveformGenerator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO Check if file exist
        // TODO: Read configuration
        // TODO: convert file in WAV file
        // TODO: generate waveform object
        // TODO: Convert it to image(SVG / PNG)
    }
}
 
