<?php

use yii\db\Migration;

/**
 * Class m211211_151813_add_auth_rows_to_users_table
 */
class m211211_151813_add_auth_rows_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'auth_key', $this->string()->null());
        $this->addColumn('users', 'password_hash', $this->string()->null());
        $this->addColumn('users', 'password_reset_token', $this->string()->null());
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211211_151813_add_auth_rows_to_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211211_151813_add_auth_rows_to_users_table cannot be reverted.\n";

        return false;
    }
    */
}
