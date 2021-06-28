<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_messages}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%users}}`
 * - `{{%tasks}}`
 */
class m210628_160817_create_users_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_messages}}', [
            'id' => $this->primaryKey(),
            'dt_add' => $this->datetime()->notNull(),
            'sender_id' => $this->integer()->notNull(),
            'recipient_id' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'is_read' => $this->tinyInteger()->notNull()->defaultValue(0),
        ]);

        // creates index for column `sender_id`
        $this->createIndex(
            '{{%idx-users_messages-sender_id}}',
            '{{%users_messages}}',
            'sender_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_messages-sender_id}}',
            '{{%users_messages}}',
            'sender_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `recipient_id`
        $this->createIndex(
            '{{%idx-users_messages-recipient_id}}',
            '{{%users_messages}}',
            'recipient_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_messages-recipient_id}}',
            '{{%users_messages}}',
            'recipient_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-users_messages-task_id}}',
            '{{%users_messages}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-users_messages-task_id}}',
            '{{%users_messages}}',
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
            '{{%fk-users_messages-sender_id}}',
            '{{%users_messages}}'
        );

        // drops index for column `sender_id`
        $this->dropIndex(
            '{{%idx-users_messages-sender_id}}',
            '{{%users_messages}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-users_messages-recipient_id}}',
            '{{%users_messages}}'
        );

        // drops index for column `recipient_id`
        $this->dropIndex(
            '{{%idx-users_messages-recipient_id}}',
            '{{%users_messages}}'
        );

        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-users_messages-task_id}}',
            '{{%users_messages}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-users_messages-task_id}}',
            '{{%users_messages}}'
        );

        $this->dropTable('{{%users_messages}}');
    }
}
