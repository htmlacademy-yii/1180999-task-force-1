<?php

use yii\db\Migration;

/**
 * Class m211028_120122_change_usersmesseges_table
 */
class m211028_120122_change_usersmesseges_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('users_messages', 'text', 'message');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211028_120122_change_usersmesseges_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211028_120122_change_usersmesseges_table cannot be reverted.\n";

        return false;
    }
    */
}
