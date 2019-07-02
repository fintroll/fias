<?php

namespace rest\modules\links\models;

use Yii;
use rest\searches\SearchAddress;
use Throwable;
use yii\base\Model;

class ProfileLinkForm extends Model
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var int $project_profile_id
     */
    public $project_profile_id;

    /**
     * @var string $fias_id
     */
    public $fias_id;

    /**
     * @var string $full_address
     */
    public $full_address;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%profiles_x_fias_link}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['fias_id'], 'required'],
            [['project_profile_id'], 'integer'],
            [['fias_id'], 'string', 'max' => 36],
            [['fias_id'], function ($attribute) {
                $model = SearchAddress::findModel($this->{$attribute});
                if ($model === null) {
                    $this->addError('fias_id', 'Объект fias_id=' . $this->{$attribute} . ' не найден');
                } else {
                    $this->full_address = $model->fullAddress;
                }
            }],
        ];
    }

    /**
     * @return bool
     * @throws Throwable
     */
    public function save():bool
    {
        if ($this->validate()) {
            $link = $this->prepareFiasLinkRecord($this->fias_id);
            if (!$link->isNewRecord){
                return true;
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $link->save();
                $this->id = $link->id;
                $transaction->commit();
                return true;
            } catch (Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function formName():string
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

    /**
     * @param string $fias_id
     * @return ProfileFiasLink
     */
    public function prepareFiasLinkRecord($fias_id): ProfileFiasLink
    {
        $model = ProfileFiasLink::find()->where(['fias_id' => $fias_id])->one();
        if ($model !== null) {
            $this->id = $model->id;
        } else {
            $model = new ProfileFiasLink();
        }


        return $model;
    }
}
