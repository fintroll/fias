<?php

namespace console\components;

use console\helpers\Directory;
use console\helpers\FileHelper;
use yii\base\Component;
use SoapClient;
use SoapFault;
use Yii;
use yii\base\InvalidConfigException;
use DomainException;

/**
 * Class LoaderComponent
 * @package console\components
 */
class LoaderComponent extends Component
{
    /**
     * @var string
     */
    public $wsdlUrl = 'http://fias.nalog.ru/WebServices/Public/DownloadService.asmx?WSDL';

    /**
     * Directory to upload file
     * @var string
     */
    public $fileDirectory = '@console/runtime/fias';

    /**
     * @var SoapResult
     */
    protected $fileInfoResult;

    /**
     * @var SoapResult
     */
    protected $allFilesInfoResult = [];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->fileDirectory = Yii::getAlias($this->fileDirectory);
        FileHelper::ensureIsDirectory($this->fileDirectory);
        FileHelper::ensureIsWritable($this->fileDirectory);
    }


    /**
     * @return SoapResult
     * @throws SoapFault
     */
    protected function getLastFileInfo(): SoapResult
    {
        if (!$this->fileInfoResult) {
            $client = new SoapClient($this->wsdlUrl);
            $rawResult = $client->__soapCall('GetLastDownloadFileInfo', []);
            $rawResultInfo = $rawResult->GetLastDownloadFileInfoResult;
            $this->fileInfoResult = new SoapResult([
                'versionId' => $rawResultInfo->VersionId,
                'updateFileUrl' => $rawResultInfo->FiasCompleteXmlUrl,
                'initFileUrl' => $rawResultInfo->FiasDeltaXmlUrl
            ]);
        }
        return $this->fileInfoResult;
    }

    /**
     * Download file from fias server
     *
     * @param $fileName
     * @param $url
     * @return string
     */
    protected function loadFile($fileName, $url)
    {
        $filePath = $this->fileDirectory . '/' . $fileName;

        if (file_exists($filePath)) {
            if ($this->isFileSizeCorrect($filePath, $url)) {
                return $filePath;
            }

            unlink($filePath);
        }

        $fp = fopen($filePath, 'w');
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_exec($ch);

        curl_close($ch);
        fclose($fp);

        return $filePath;
    }

    /**
     * @param $path
     *
     * @param $version
     *
     * @return Directory
     * @throws \yii\base\InvalidConfigException
     */
    protected function wrap($path, $version)
    {
        $pathToDirectory = glob($path . '_*');
        if ($pathToDirectory) {
            $pathToDirectory = $pathToDirectory[0];
        } else {
            $pathToDirectory = Dearchiver::extract($this->fileDirectory, $path);
        }
        $this->addVersionId($pathToDirectory, $version);

        return new Directory($pathToDirectory);
    }

    /**
     * @param $pathToDirectory
     * @param $versionId
     */
    protected function addVersionId($pathToDirectory, $versionId)
    {
        file_put_contents($pathToDirectory . '/VERSION_ID_' . $versionId, 'Версия: ' . $versionId);
    }

    /**
     * Check size for downloaded file and file in fias server
     *
     * @param $filePath
     * @param $url
     * @return bool
     */
    public function isFileSizeCorrect($filePath, $url): bool
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);

        curl_exec($ch);

        $correctSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

        curl_close($ch);

        return filesize($filePath) === $correctSize;
    }

    /**
     * @param $currentVersion
     * @return bool
     * @throws SoapFault
     */
    public function isUpdateRequired($currentVersion): bool
    {
        $filesInfo = $this->getLastFileInfo();

        return $currentVersion !== $filesInfo->versionId;
    }

    /**
     * @param SoapResult $filesInfo
     *
     * @return Directory
     * @throws InvalidConfigException
     */
    public function loadInitFile(SoapResult $filesInfo): Directory
    {
        return $this->load($filesInfo->getInitFileName(), $filesInfo->initFileUrl, $filesInfo->versionId);
    }

    /**
     * @param SoapResult $filesInfo
     *
     * @return Directory
     * @throws InvalidConfigException
     */
    public function loadUpdateFile(SoapResult $filesInfo): Directory
    {
        return $this->load($filesInfo->getUpdateFileName(), $filesInfo->updateFileUrl, $filesInfo->versionId);
    }

    /**
     * @param string $filename
     * @param string $url
     *
     * @param $version
     *
     * @return Directory
     * @throws InvalidConfigException
     */
    private function load($filename, $url, $version): Directory
    {
        return $this->wrap(
            $this->loadFile($filename, $url),
            $version
        );
    }

    /**
     * @param $pathToDirectory
     *
     * @return Directory
     * @throws InvalidConfigException
     */
    public function wrapDirectory($pathToDirectory): Directory
    {
        return new Directory($pathToDirectory);
    }

    /**
     * @param int $fromVersion
     * @return SoapResult[]
     * @throws SoapFault
     */
    public function getAllFilesInfo($fromVersion = 0): array
    {
        if (!isset($this->allFilesInfoResult[$fromVersion])) {
            $this->allFilesInfoResult[$fromVersion] = $this->getAllFilesInfoRaw($fromVersion);
        }
        return $this->allFilesInfoResult[$fromVersion];
    }

    /**
     * @param int $fromVersion
     * @return SoapResult[]
     * @throws SoapFault
     */
    protected function getAllFilesInfoRaw($fromVersion = 0): array
    {
        $client = new SoapClient($this->wsdlUrl);
        $rawResult = $client->__soapCall('GetAllDownloadFileInfo', []);
        $updates = [];
        foreach ($rawResult->GetAllDownloadFileInfoResult->DownloadFileInfo as $update) {
            if ($update->VersionId <= $fromVersion) {
                continue;
            }
            $updates[] = new SoapResult($update);
        }
        return $updates;
    }

    /**
     * @param null $version
     * @return SoapResult|mixed
     * @throws SoapFault
     */
    public function getVersionFileInfo($version = null)
    {
        if ($version === null) {
            return $this->getLastFileInfo();
        }
        $allFilesInfo = $this->getAllFilesInfo();
        foreach ($allFilesInfo as $info) {
            if ($info->versionId === $version) {
                return $info;
            }
        }
        throw new DomainException('Версия не найдена.');
    }

}