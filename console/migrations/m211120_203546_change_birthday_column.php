<?php

use yii\db\Migration;

/**
 * Class m211120_203546_change_birthday_column
 */
class m211120_203546_change_birthday_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('users', 'birthday', $this->date()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211120_203546_change_birthday_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211120_203546_change_birthday_column cannot be reverted.\n";

        return false;
    }
    */
}
