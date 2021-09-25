<?php

use yii\db\Migration;

/**
 * Class m210921_193923_change_files_table
 */
class m210921_193923_change_files_table extends Migration
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
        echo "m210921_193923_change_files_table cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('files', 'name', $this->string(255)->notNull());
    }

    public function down()
    {
        $this->dropColumn('files', 'name');
    }

}
