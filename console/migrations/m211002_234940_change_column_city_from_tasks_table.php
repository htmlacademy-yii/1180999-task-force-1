<?php

use yii\db\Migration;

/**
 * Class m211002_234940_change_column_city_from_tasks_table
 */
class m211002_234940_change_column_city_from_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211002_234940_change_column_city_from_tasks_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211002_234940_change_column_city_from_tasks_table cannot be reverted.\n";

        return false;
    }
    */
}
