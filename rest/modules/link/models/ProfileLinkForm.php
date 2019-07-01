<?php

namespace rest\modules\links\models;

use common\models\fias\ProfileFiasLink as CommonLink;


class ProfileLinkForm extends CommonLink
{
    /**
     * {@inheritdoc}
     */
    public static function tableName():string
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
            [['project_profile_id'], 'integer'],
            [['fias_id'], 'string', 'max' => 36],
        ];
    }

    public function formName()
    {
        return '';
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
}
