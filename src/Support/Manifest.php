<?php

namespace Maid\Sdk\Support;

use Maid\Sdk\Exceptions\ManifestException;
use Illuminate\Support\Arr;
use Symfony\Component\Yaml\Yaml;

class Manifest
{
    public static function get(string|int|null $key = null): mixed
    {
        $filename = self::getFilename();

        if (!file_exists($filename)) {
            throw new ManifestException(sprintf('Maid manifest file not found at %s', $filename));
        }

        return Arr::get(Yaml::parseFile($filename), $key);
    }

    public static function dump(array $manifest): string
    {
        return Yaml::dump($manifest, 512, 2);
    }

    public static function save(array $manifest): void
    {
        file_put_contents(self::getFilename(), self::dump($manifest));
    }

    public static function getFilename(): string
    {
        return getcwd() . DIRECTORY_SEPARATOR . 'maid.yml';
    }
}