<?php

use yii\db\Migration;

/**
 * Class m190903_081151_fias_link_apartment
 */
class m190903_081151_fias_link_apartment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{profiles_x_fias_link}}', 'apartment', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{profiles_x_fias_link}}', 'apartment');

    }
}
