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
            'postalcode' => 'POSTALCODE',
            'regioncode' => 'REGIONCODE',
            'ifnsfl' => 'IFNSFL',
            'terrifnsfl' => 'TERRIFNSFL',
            'ifnsul' => 'IFNSUL',
            'terrifnsul' => 'TERRIFNSUL',
            'okato' => 'OKATO',
            'oktmo' => 'OKTMO',
            'updatedate' => 'UPDATEDATE',
            'housenum' => 'HOUSENUM',
            'eststatus' => 'ESTSTATUS',
            'buildnum' => 'BUILDNUM',
            'strucnum' => 'STRUCNUM',
            'strstatus' => 'STRSTATUS',
            'houseid' => 'HOUSEID',
            'houseguid' => 'HOUSEGUID',
            'aoguid' => 'AOGUID',
            'startdate' => 'STARTDATE',
            'enddate' => 'ENDDATE',
            'statstatus' => 'STATSTATUS',
            'normdoc' => 'NORMDOC',
            'counter' => 'COUNTER',
            'cadnum' => 'CADNUM',
            'divtype' => 'DIVTYPE',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Addrobj::class, ['AOID' => 'AOGUID']);
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
