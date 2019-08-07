<?php

namespace rest\modules\search\models;

class Addrobj extends SphinxAddrobj
{
    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'value' => 'fullAddress',
            'id' => 'aoguid',
            'name' => 'fullname',
            'treeRecursive'
        ];
    }
}
