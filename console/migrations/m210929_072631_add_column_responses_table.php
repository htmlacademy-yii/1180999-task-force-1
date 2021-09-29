<?php

use yii\db\Migration;

/**
 * Class m210929_072631_add_column_responses_table
 */
class m210929_072631_add_column_responses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('responses',
            'refuse', $this->string()->null());    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210929_072631_add_column_responses_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210929_072631_add_column_responses_table cannot be reverted.\n";

        return false;
    }
    */
}
