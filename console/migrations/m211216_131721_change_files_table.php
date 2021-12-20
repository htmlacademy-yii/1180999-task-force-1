<?php

use yii\db\Migration;

/**
 * Class m211216_131721_change_files_table
 */
class m211216_131721_change_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('files', 'path', $this->string(255)->notNull());
        $this->dropIndex('path', 'files');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('files', 'path', $this->string(255)->notNull()->unique());
        $this->addIndex('path', 'files');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211216_131721_change_files_table cannot be reverted.\n";

        return false;
    }
    */
}
