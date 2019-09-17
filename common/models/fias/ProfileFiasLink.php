<?php

namespace common\models\fias;

use rest\searches\SearchAddress;
use Yii;
use rest\modules\address\models\House;
use rest\modules\address\models\Addrobj;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%profiles_x_fias_link}}".
 *
 * @property int $id
 * @property string $project_profile_id ID Анкеты в проекте
 * @property string $fias_id Fias_id
 * @property string $apartment Apartment
 * @property string $house Apartment
 * @property string $postal Apartment
 * @property House|Addrobj $fiasData
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
            [['apartment','house'], 'string', 'max' => 255],
            [['postal'], 'string', 'max' => 6],
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
     * @return Addrobj|House
     */
    public function getFiasData()
    {
        return SearchAddress::findModel($this->fias_id);
    }
}
