<?php

use yii\db\Migration;

/**
 * Class m211015_193043_change_tasks_table
 */
class m211015_193043_change_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('tasks', 'location', 'city_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('tasks', 'city_id', 'location');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211015_193043_change_tasks_table cannot be reverted.\n";

        return false;
    }
    */
}
