<?php

namespace GhostZero\Maid\Support;

use Symfony\Component\Yaml\Yaml as SymfonyYaml;

class Yaml
{
    const YAML_SEPARATOR = "---\n";

    public static function parseFile(string $filename): mixed
    {
        return SymfonyYaml::parseFile($filename);
    }

    public static function parse(string $input): mixed
    {
        return SymfonyYaml::parse($input);
    }

    public static function dumpMany(array $input): string
    {
        return SymfonyYaml::dump(implode(self::YAML_SEPARATOR, $input), 512, 2);
    }

    public static function dump(mixed $input): string
    {
        return SymfonyYaml::dump($input, 512, 2);
    }
}