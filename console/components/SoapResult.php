<?php
namespace console\components;

use yii\base\Component;

/**
 * Class SoapResult
 * @package console\models
 */
class SoapResult extends Component
{
    /**
     * @var int $versionId
     */
    public $versionId;
    /**
     * @var string $updateFileUrl
     */
    public $updateFileUrl;
    /**
     * @var string $initFileUrl
     */
    public $initFileUrl;

    /**
     * @return string
     */
    public function getUpdateFileName():string
    {
        $fileName = basename($this->updateFileUrl);
        return $this->versionId . '_' . $fileName;
    }

    /**
     * @return string
     */
    public function getInitFileName():string
    {
        $fileName = basename($this->initFileUrl);
        return $this->versionId . '_' . $fileName;
    }
}
