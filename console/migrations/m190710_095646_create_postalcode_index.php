<?php

use yii\db\Migration;

/**
 * Class m190710_095646_create_postalcode_index
 */
class m190710_095646_create_postalcode_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('IDXPOSTALCODE','{{%HOUSE}}', ['POSTALCODE']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('IDXPOSTALCODE','{{%HOUSE}}');
    }
}
