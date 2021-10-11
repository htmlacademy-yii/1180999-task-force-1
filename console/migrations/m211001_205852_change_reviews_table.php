<?php

use yii\db\Migration;

/**
 * Class m211001_205852_change_reviews_table
 */
class m211001_205852_change_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('reviews', 'dt_add', $this->dateTime()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('reviews', 'dt_add', $this->dateTime()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211001_205852_change_reviews_table cannot be reverted.\n";

        return false;
    }
    */
}
