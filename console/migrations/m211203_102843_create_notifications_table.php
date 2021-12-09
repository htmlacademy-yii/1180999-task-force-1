<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notifications}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%tasks}}`
 */
class m211203_102843_create_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notifications}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(255)->null(),
            'icon' => $this->string(255)->notNull(),
            'is_read' => $this->tinyInteger()->notNull()->defaultValue(0),
            'user_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-notifications-user_id}}',
            '{{%notifications}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-notifications-user_id}}',
            '{{%notifications}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-notifications-task_id}}',
            '{{%notifications}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-notifications-task_id}}',
            '{{%notifications}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-notifications-user_id}}',
            '{{%notifications}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-notifications-user_id}}',
            '{{%notifications}}'
        );

        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-notifications-task_id}}',
            '{{%notifications}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-notifications-task_id}}',
            '{{%notifications}}'
        );

        $this->dropTable('{{%notifications}}');
    }
}
