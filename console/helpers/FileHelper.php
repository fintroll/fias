<?php

namespace console\helpers;

use yii\base\InvalidConfigException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;

/**
 * Class FileHelper
 * @package console\helpers
 */
class FileHelper
{
    /**
     * @param $path
     * @throws InvalidConfigException
     */
    public static function ensureIsReadable($path): void
    {
        if (!is_readable($path)) {
            throw new InvalidConfigException('Путь недоступен для чтения: ' . $path);
        }
    }

    /**
     * @param $path
     * @throws InvalidConfigException
     */
    public static function ensureIsWritable($path): void
    {
        if (!is_writable($path)) {
            throw new InvalidConfigException('Путь недоступен для записи: ' . $path);
        }
    }

    /**
     * @param $path
     * @return bool
     */
    public static function ensureIsDirectory($path): bool
    {
        return mkdir($path) || is_dir($path);
    }

    /**
     * @param $path
     * @return bool
     */
    public static function clearDirectory($path): bool
    {
        $di = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
        $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($ri as $file) {
            $file->isDir() ? rmdir($file) : unlink($file);
        }
        return true;
    }
}
