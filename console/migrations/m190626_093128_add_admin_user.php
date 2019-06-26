<?php


use yii\db\Migration;

/**
 * Class m190626_093128_add_admin_user
 */
class m190626_093128_add_admin_user extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'auth_key' => 'ZFhpxWrhuRACreAoMlSqofnm0bgMgoOu',
            'password_hash' => '$2y$13$oS.u2jAKGvieF.aK6l4gcucI40v/XiGcIIOiNSHr9AnYZwlS1KPTO',
            'password_reset_token' => '',
            'email' => 'admin@example.com',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%user}}');
    }
}
