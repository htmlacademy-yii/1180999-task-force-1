<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks_files}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tasks}}`
 * - `{{%files}}`
 */
class m210628_160807_create_tasks_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks_files}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'file_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-tasks_files-task_id}}',
            '{{%tasks_files}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-tasks_files-task_id}}',
            '{{%tasks_files}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );

        // creates index for column `file_id`
        $this->createIndex(
            '{{%idx-tasks_files-file_id}}',
            '{{%tasks_files}}',
            'file_id'
        );

        // add foreign key for table `{{%files}}`
        $this->addForeignKey(
            '{{%fk-tasks_files-file_id}}',
            '{{%tasks_files}}',
            'file_id',
            '{{%files}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-tasks_files-task_id}}',
            '{{%tasks_files}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-tasks_files-task_id}}',
            '{{%tasks_files}}'
        );

        // drops foreign key for table `{{%files}}`
        $this->dropForeignKey(
            '{{%fk-tasks_files-file_id}}',
            '{{%tasks_files}}'
        );

        // drops index for column `file_id`
        $this->dropIndex(
            '{{%idx-tasks_files-file_id}}',
            '{{%tasks_files}}'
        );

        $this->dropTable('{{%tasks_files}}');
    }
}
