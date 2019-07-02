<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profiles_x_fias_link}}`.
 */
class m190701_132810_create_profiles_x_fias_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profiles_x_fias_link}}', [
            'id' => $this->primaryKey(),
            'project_profile_id' => $this->string()->notNull()->comment('ID Анкеты в проекте'),
            'fias_id' => $this->string(36)->notNull()->comment('Fias_id'),
        ]);
        $this->createIndex('idx_link_project_profile_id','{{%profiles_x_fias_link}}', 'project_profile_id');
        $this->createIndex('idx_link_id','{{%profiles_x_fias_link}}', 'fias_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_link_id', '{{%profiles_x_fias_link}}');
        $this->dropIndex('idx_link_project_profile_id', '{{%profiles_x_fias_link}}');
        $this->dropTable('{{%profiles_x_fias_link}}');
    }
}
