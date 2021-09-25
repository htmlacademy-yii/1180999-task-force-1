<?php

use yii\db\Migration;

/**
 * Class m210922_061713_change_tasks_table
 */
class m210922_061713_change_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tasks', 'deadline', $this->dateTime()->null());
        $this->renameColumn('tasks', 'city_id', 'location');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210922_061713_change_tasks_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210922_061713_change_tasks_table cannot be reverted.\n";

        return false;
    }
    */
}
