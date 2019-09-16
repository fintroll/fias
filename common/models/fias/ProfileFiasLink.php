<?php

namespace common\models\fias;

use Yii;
use rest\modules\address\models\House;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%profiles_x_fias_link}}".
 *
 * @property int $id
 * @property string $project_profile_id ID Анкеты в проекте
 * @property string $fias_id Fias_id
 * @property string $apartment Apartment
 * @property House $house
 */
class ProfileFiasLink extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profiles_x_fias_link}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['project_profile_id', 'fias_id'], 'required'],
            [['project_profile_id', 'fias_id'], 'string', 'max' => 36],
            [['apartment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'project_profile_id' => 'ID Анкеты в проекте',
            'fias_id' => 'Fias_id',
            'apartment' => 'Apartment',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProfileFiasLinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileFiasLinkQuery(static::class);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHouse()
    {
        return $this->hasOne(House::class, ['HOUSEID' => 'fias_id']);
    }
}
