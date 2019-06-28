<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fias_update_log}}`.
 */
class m190628_080011_create_fias_update_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fias_update_log}}', [
            'id' => $this->primaryKey(),
            'version_id' => $this->integer()->unique()->notNull()->comment('Версия базы ФИАС'),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fias_update_log}}');
    }
}
