<?php

use yii\db\Migration;

/**
 * Class m210927_224338_change_responses_table
 */
class m210927_224338_change_responses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('responses', 'description', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210927_224338_change_responses_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210927_224338_change_responses_table cannot be reverted.\n";

        return false;
    }
    */
}
