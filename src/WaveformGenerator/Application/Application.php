<?php

namespace WaveformGenerator\Application;

use Symfony\Component\Console\Application as ApplicationBase;
use Symfony\Component\Console\Input\InputInterface;
use WaveformGenerator\Command\WaveformGeneratorCommand;

/**
 * Class Application
 * @package WaveformGenerator\Application
 */
class Application extends ApplicationBase
{
    protected function getCommandName(InputInterface $input)
    {
        return 'waveform-generator';
    }

    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new WaveformGeneratorCommand();

        return $defaultCommands;
    }

    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}
