<?php

namespace rest\modules\address\models;

use Yii;


class House extends \common\models\fias\House
{
 /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'houseid' => 'HOUSEID',
            'houseguid' => 'HOUSEGUID',
            'housenum' => 'HOUSENUM',
            'eststatus' => 'ESTSTATUS',
            'buildnum' => 'BUILDNUM',
            'strucnum' => 'STRUCNUM',
            'address'
        ];
    }

    public function extraFields()
    {
        return [
            'aoguid' => 'AOGUID',
            'cadnum' => 'CADNUM',
            'normdoc' => 'NORMDOC',
            'counter' => 'COUNTER',
            'strstatus' => 'STRSTATUS',
            'statstatus' => 'STATSTATUS',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Addrobj::class, ['AOGUID' => 'AOGUID']);
    }

    /**
     * @return mixed|string
     */
    public function getFullAddress()
    {
        $address = isset($this->address) ? $this->getFullAddress() : $this->HOUSENUM;

        if (!empty($this->BUILDNUM)) {
            $address .= '/' . $this->BUILDNUM;
        }

        if (!empty($this->STRUCNUM)) {
            $address .= '/' . $this->STRUCNUM;
        }

        return $address;
    }

    /**
     * @return string
     */
    public function getFullNumber()
    {
        $number = $this->HOUSENUM;

        if (!empty($this->BUILDNUM)) {
            $number .= ' корп. ' . $this->BUILDNUM;
        }

        if (!empty($this->STRUCNUM)) {
            $number .= ' стр. ' . $this->STRUCNUM;
        }

        return $number;
    }
}
