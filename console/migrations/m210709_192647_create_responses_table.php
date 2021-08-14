<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%responses}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%tasks}}`
 */
class m210709_192647_create_responses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%responses}}', [
            'id' => $this->primaryKey(),
            'dt_add' => $this->datetime()->notNull(),
            'executor_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'price' => $this->integer()->notNull(),
        ]);

        // creates index for column `executor_id`
        $this->createIndex(
            '{{%idx-responses-executor_id}}',
            '{{%responses}}',
            'executor_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-responses-executor_id}}',
            '{{%responses}}',
            'executor_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-responses-task_id}}',
            '{{%responses}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-responses-task_id}}',
            '{{%responses}}',
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
            '{{%fk-responses-executor_id}}',
            '{{%responses}}'
        );

        // drops index for column `executor_id`
        $this->dropIndex(
            '{{%idx-responses-executor_id}}',
            '{{%responses}}'
        );

        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-responses-task_id}}',
            '{{%responses}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-responses-task_id}}',
            '{{%responses}}'
        );

        $this->dropTable('{{%responses}}');
    }
}
