<?php

namespace WaveformGenerator;

use Symfony\Component\Finder\Finder;

/**
 * Inspired By Composer Compiler class
 * @package WaveformGenerator
 */
class Compiler
{
    public function compile($pharFile = 'waveform-generator.phar')
    {
        if (file_exists($pharFile)) {
            unlink($pharFile);
        }

        $phar = new \Phar($pharFile, 0, 'waveform-generator.phar');
        $phar->setSignatureAlgorithm(\Phar::SHA1);

        $phar->startBuffering();

        $finder = new Finder();
        $finder->files()
            ->ignoreVCS(true)
            ->name('*.php')
            ->notName('Compiler.php')
            ->in(__DIR__ . '/..');

        foreach ($finder as $file) {
            $this->addFile($phar, $file);
        }

        $finder = new Finder();
        $finder->files()
            ->ignoreVCS(true)
            ->name('*.php')
            ->exclude('Tests')
            ->in(__DIR__ . '/../../vendor/symfony/');

        foreach ($finder as $file) {
            $this->addFile($phar, $file);
        }

        $this->addFile($phar, new \SplFileInfo(__DIR__ . '/../../vendor/autoload.php'));
        $this->addFile($phar, new \SplFileInfo(__DIR__ . '/../../vendor/composer/autoload_namespaces.php'));
        $this->addFile($phar, new \SplFileInfo(__DIR__ . '/../../vendor/composer/autoload_psr4.php'));
        $this->addFile($phar, new \SplFileInfo(__DIR__ . '/../../vendor/composer/autoload_classmap.php'));
        $this->addFile($phar, new \SplFileInfo(__DIR__ . '/../../vendor/composer/autoload_real.php'));
        $this->addFile($phar, new \SplFileInfo(__DIR__ . '/../../vendor/composer/ClassLoader.php'));
        $this->addFile($phar, new \SplFileInfo(__DIR__ . '/../../vendor/composer/include_paths.php'));

        $this->addAlreadyExtractBin($phar);
        $phar->setStub($this->getStub());

        $phar->stopBuffering();

        unset($phar);
    }

    /**
     * @param \Phar $phar
     * @param $file
     */
    private function addFile($phar, $file)
    {
        $path = strtr(str_replace(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR, '', $file->getRealPath()), '\\', '/');

        $content = file_get_contents($file);
        $content = $this->stripWhitespace($content);

        $phar->addFromString($path, $content);
    }

    /**
     * @param \Phar $phar
     */
    private function addAlreadyExtractBin($phar)
    {
        $content = file_get_contents(__DIR__ . '/../../bin/already-extract');
        $content = preg_replace('{^#!/usr/bin/env php\s*}', '', $content);
        $phar->addFromString('bin/waveform-generator', $content);
    }

    private function getStub()
    {
        $stub = <<<'EOF'
#!/usr/bin/env php
<?php

Phar::mapPhar('waveform-generator.phar');

EOF;

        return $stub . <<<'EOF'
require 'phar://waveform-generator.phar/bin/waveform-generator';

__HALT_COMPILER();
EOF;
    }

    /**
     * Removes whitespace from a PHP source string while preserving line numbers.
     *
     * @param  string $source A PHP string
     * @return string The PHP string with the whitespace removed
     */
    private function stripWhitespace($source)
    {
        if (!function_exists('token_get_all')) {
            return $source;
        }

        $output = '';
        foreach (token_get_all($source) as $token) {
            if (is_string($token)) {
                $output .= $token;
            } elseif (in_array($token[0], array(T_COMMENT, T_DOC_COMMENT))) {
                $output .= str_repeat("\n", substr_count($token[1], "\n"));
            } elseif (T_WHITESPACE === $token[0]) {
                // reduce wide spaces
                $whitespace = preg_replace('{[ \t]+}', ' ', $token[1]);
                // normalize newlines to \n
                $whitespace = preg_replace('{(?:\r\n|\r|\n)}', "\n", $whitespace);
                // trim leading spaces
                $whitespace = preg_replace('{\n +}', "\n", $whitespace);
                $output .= $whitespace;
            } else {
                $output .= $token[1];
            }
        }

        return $output;
    }
}
