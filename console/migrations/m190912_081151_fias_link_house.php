<?php

use yii\db\Migration;

/**
 * Class m190912_081151_fias_link_house
 */
class m190912_081151_fias_link_house extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{profiles_x_fias_link}}', 'house', $this->string(255));
        $this->addColumn('{{profiles_x_fias_link}}', 'postal', $this->string(6));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{profiles_x_fias_link}}', 'house');
        $this->addColumn('{{profiles_x_fias_link}}', 'postal', $this->string(6));

    }
}
