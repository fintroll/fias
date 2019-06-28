<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class FiasUpdateLog
 * @package common\models
 */
class FiasUpdateLog extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%fias_update_log}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['version_id', 'created_at'], 'required'],
            [['version_id', 'created_at'], 'integer'],
            [['version_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'version_id' => 'Версия базы',
            'created_at' => 'Дата обновления',
        ];
    }
}
