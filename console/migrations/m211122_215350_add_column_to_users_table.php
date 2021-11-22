<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m211122_215350_add_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'notification_new_review', $this->tinyInteger()->defaultValue(0));
        $this->addColumn('users', 'hide_profile', $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'notification_new_review');
        $this->dropColumn('users', 'hide_profile');
    }
}
