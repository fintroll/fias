<?php

namespace rest\modules\link\models;

use common\models\fias\House;
use Yii;
use common\models\fias\ProfileFiasLink;
use Throwable;
use yii\base\Model;

/**
 * Class ProfileLinkForm
 * @package rest\modules\link\models
 */
class ProfileLinkForm extends Model
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $fias_link_id
     */
    public $fias_link_id;

    /**
     * @var string $fias_id
     */
    public $fias_id;

    /**
     * @var string $apartment
     */
    public $apartment;

    /**
     * @var string $house
     */
    public $house;

    /**
     * @var string $postal
     */
    public $postal;


    /**
     * @var ProfileFiasLink $link
     */
    private $link;

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
            [['fias_id'], 'string', 'max' => 36],
            [['apartment', 'house', 'postal'], 'string', 'max' => 255],
            [['postal'], 'string', 'max' => 6],
        ];
    }

    /**
     * @return bool
     * @throws Throwable
     */
    public function save(): bool
    {
        if ($this->validate()) {
            $this->link = $this->prepareFiasLinkRecord();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!$this->link->save()) {
                    $transaction->rollBack();
                    return false;
                }
                $this->id = $this->link->id;
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
    public function formName(): string
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
            'apartment' => 'квартира/офис',
        ];
    }

    /**
     * @return mixed
     */
    public function getPrimaryKey()
    {
        return $this->link->getPrimaryKey(true);
    }

    /**
     * @return ProfileFiasLink
     */
    public function prepareFiasLinkRecord(): ProfileFiasLink
    {
        $model = ProfileFiasLink::find()->where(['fias_id' => $this->fias_id, 'apartment' => $this->apartment])->one();
        if ($model !== null) {
            $this->id = $model->id;
            $this->fias_link_id = $model->project_profile_id;
        } else {
            $model = new ProfileFiasLink();
            $model->fias_id = $this->fias_id;
            $model->apartment = $this->apartment;
            $model->house = $this->house;
            $model->postal = $this->postal;
            $model->project_profile_id = uniqid('fias_', false);
            $this->fias_link_id = $model->project_profile_id;
        }
        return $model;
    }
}
