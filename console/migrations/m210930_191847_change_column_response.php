<?php

use yii\db\Migration;

/**
 * Class m210930_191847_change_column_response
 */
class m210930_191847_change_column_response extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('responses', 'dt_add', $this->dateTime()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('responses', 'dt_add', $this->dateTime()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210930_191847_change_column_response cannot be reverted.\n";

        return false;
    }
    */
}
