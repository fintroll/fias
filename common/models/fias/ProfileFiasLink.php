<?php

namespace common\models\fias;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%profiles_x_fias_link}}".
 *
 * @property int $id
 * @property int $project_profile_id ID Анкеты в проекте
 * @property string $fias_id Fias_id
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
            [['project_profile_id','fias_id'], 'string', 'max' => 36],
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
}
