<?php

namespace console\helpers;

use yii\base\InvalidConfigException;
use yii\console\Exception;

/**
 * Class Directory
 * @package console\helpers
 */
class Directory
{
    /**
     * @var string $directoryPath
     */
    private $directoryPath;

    /**
     * @param $path
     * @throws InvalidConfigException
     */
    public function __construct($path)
    {
        FileHelper::ensureIsReadable($path);
        FileHelper::ensureIsDirectory($path);

        $this->directoryPath = $path;
    }

    /**
     * Получить id версии базы fias
     *
     * @return mixed
     * @throws Exception
     */
    public function getVersionId()
    {
        $prefix = 'VERSION_ID_';
        return str_replace($prefix, '', $this->find($prefix));
    }

    /**
     * @return null|string
     * @throws Exception
     */
    public function getDeletedAddressObjectFile(): ?string
    {
        $fileName = $this->find('AS_DEL_ADDROBJ', false);
        return $fileName ? $this->directoryPath . '/' . $fileName : null;
    }

    /**
     * @return null|string
     * @throws Exception
     */
    public function getDeletedHouseFile(): ?string
    {
        $fileName = $this->find('AS_DEL_HOUSE_', false);
        return $fileName ? $this->directoryPath . '/' . $fileName : null;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getAddressObjectFile(): string
    {
        return $this->directoryPath . '/' . $this->find('AS_ADDROBJ');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getHouseFile(): string
    {
        return $this->directoryPath . '/' . $this->find('AS_HOUSE_');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getAddressObjectLevelFile(): string
    {
        return $this->directoryPath . '/' . $this->find('AS_SOCRBASE');
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->directoryPath;
    }

    /**
     * @param $prefix
     * @param bool $isIndispensable
     * @return string|null
     * @throws Exception
     */
    private function find($prefix, $isIndispensable = true): ?string
    {
        $files = scandir($this->directoryPath);
        foreach ($files as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            if (mb_strpos($file, $prefix) === 0) {
                return $file;
            }
        }

        if ($isIndispensable) {
            throw new Exception('Файл с префиксом ' . $prefix . ' не найден в каталоге: ' . $this->directoryPath);
        }

        return null;
    }
}
