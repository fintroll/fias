<?php

namespace console\components;

use console\helpers\Directory;
use solbianca\fias\console\base\XmlReader;
use solbianca\fias\models\FiasAddressObject;
use solbianca\fias\models\FiasHouse;
use common\models\FiasUpdateLog;
use solbianca\fias\Module;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\console\Exception;
use yii\helpers\Console;

/**
 * Class UpdateComponent
 * @package console\components
 */
class UpdateComponent extends Component
{

    /**
     * @var LoaderComponent
     */
    protected $loader;


    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->loader = new LoaderComponent();
    }


    /**
     * Save log
     *
     * @param int $versionId
     */
    final protected function saveLog($versionId)
    {
        if ( ! $log = FiasUpdateLog::findOne(['version_id' => $versionId])) {
            $log             = new FiasUpdateLog();
            $log->version_id = $versionId;
        }

        $log->created_at = time();
        $log->save(false);
    }

    /**
     * @param SoapResult $fileInfo
     * @param null $file
     * @return \console\components\Directory|Directory
     * @throws Exception
     * @throws InvalidConfigException
     */
    final protected function getDirectory(SoapResult $fileInfo, $file = null)
    {
        if (null !== $file) {
            if ( ! file_exists($file)) {
                throw new Exception("File {$file} does not exist.");
            }
            $directory = $this->loader->wrapDirectory(Yii::getAlias($file));
        } else {
            $directory = $this->loadFile($fileInfo);
        }

        return $directory;
    }

    /**
     * @param SoapResult $fileInfo
     *
     * @return Directory
     * @throws InvalidConfigException
     */
    protected function loadFile(SoapResult $fileInfo)
    {
        return $this->loader->loadUpdateFile($fileInfo);
    }


    /**
     * @param null|int $fromVersion
     *
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\console\Exception
     * @throws \yii\db\Exception
     */
    public function update($fromVersion = null)
    {

        if ($fromVersion === null) {
            /** @var FiasUpdateLog $currentVersion */
            $currentVersion = FiasUpdateLog::find()->orderBy('id desc')->limit(1)->one();

            if ( ! $currentVersion) {
                Console::output('База не инициализированна, выполните команду: php yii fias/install');

                return;
            }

            $updates = $this->loader->getAllFilesInfo($currentVersion->version_id);
            $updateVersion = $currentVersion->version_id;

        } else {
            $updates = $this->loader->getAllFilesInfo($fromVersion);
            $updateVersion = $fromVersion;
        }

        if (empty($updates)) {
            Console::output(Yii::$app->formatter->asDateTime(time(),
                    'php:Y-m-d H:i:s') . ' ' . 'База в актуальном состоянии');
            return;
        }

        foreach ($updates as $update) {

            $directory = $this->getDirectory($update);
            Console::output(Yii::$app->formatter->asDateTime(time(),
                    'php:Y-m-d H:i:s') . ' ' . "Обновление с версии {$updateVersion} до версии {$update->getVersionId()}");
            $this->deleteFiasData($directory);
            $transaction = $this->db->beginTransaction();
            try {
                $this->db->createCommand('SET foreign_key_checks = 0;')->execute();
                $this->updateAddressObject($directory);
                $this->updateHouse($directory);
                $this->saveLog($update->getVersionId());
                $this->db->createCommand('SET foreign_key_checks = 1;')->execute();
                $transaction->commit();
                $updateVersion = $update->getVersionId();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

    }

    /**
     * @param Directory $directory
     *
     * @throws \yii\console\Exception
     * @throws \yii\base\InvalidConfigException
     */
    private function deleteFiasData(Directory $directory)
    {
        Console::output('Удаление данных.');

        $deletedHouseFile = $directory->getDeletedHouseFile();
        if ($deletedHouseFile) {
            Console::output("Удаление записей из таблицы " . FiasHouse::tableName() . ".");
            FiasHouse::remove(new XmlReader(
                $deletedHouseFile,
                FiasHouse::XML_OBJECT_KEY,
                array_keys(FiasHouse::getXmlAttributes()),
                FiasHouse::getXmlFilters()
            ));
        }

        $deletedAddressObjectsFile = $directory->getDeletedAddressObjectFile();
        if ($deletedAddressObjectsFile) {
            Console::output("Удаление записей из таблицы " . FiasAddressObject::tableName() . ".");
            FiasAddressObject::remove(new XmlReader(
                $deletedAddressObjectsFile,
                FiasAddressObject::XML_OBJECT_KEY,
                array_keys(FiasAddressObject::getXmlAttributes()),
                FiasAddressObject::getXmlFilters()
            ));
        }
    }

    /**
     * @param Directory $directory
     *
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\console\Exception
     * @throws \yii\db\Exception
     */
    private function updateAddressObject(Directory $directory)
    {
        Console::output('Обновление адресов объектов');

        $attributes           = FiasAddressObject::getXmlAttributes();
        $attributes['PREVID'] = 'previous_id';

        FiasAddressObject::updateRecords(new XmlReader(
            $directory->getAddressObjectFile(),
            FiasAddressObject::XML_OBJECT_KEY,
            array_keys($attributes),
            FiasAddressObject::getXmlFilters()
        ), $attributes);

    }

    /**
     * @param Directory $directory
     *
     * @throws InvalidConfigException
     * @throws Exception
     * @throws \yii\db\Exception
     */
    private function updateHouse(Directory $directory)
    {
        Console::output('Обновление домов');

        $attributes           = FiasHouse::getXmlAttributes();
        $attributes['PREVID'] = 'previous_id';

        FiasHouse::updateRecords(new XmlReader(
            $directory->getHouseFile(),
            FiasHouse::XML_OBJECT_KEY,
            array_keys($attributes),
            FiasHouse::getXmlFilters()
        ), $attributes);
    }
}