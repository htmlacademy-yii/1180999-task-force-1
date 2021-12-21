<?php

use yii\db\Migration;

/**
 * Class m211219_103926_change_tasks_table
 */
class m211219_103926_change_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'address', $this->text()->null());
        $this->addColumn('tasks', 'location', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tasks', 'address');
        $this->dropColumn('tasks', 'location');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211219_103926_change_tasks_table cannot be reverted.\n";

        return false;
    }
    */
}
