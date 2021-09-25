<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reviews}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%users}}`
 * - `{{%tasks}}`
 */
class m210819_141441_create_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'dt_add' => $this->datetime()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'executor_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'score' => $this->tinyInteger()->null()->defaultValue(0),
            'text' => $this->text()->null(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-reviews-user_id}}',
            '{{%reviews}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-reviews-user_id}}',
            '{{%reviews}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `executor_id`
        $this->createIndex(
            '{{%idx-reviews-executor_id}}',
            '{{%reviews}}',
            'executor_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-reviews-executor_id}}',
            '{{%reviews}}',
            'executor_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-reviews-task_id}}',
            '{{%reviews}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-reviews-task_id}}',
            '{{%reviews}}',
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
            '{{%fk-reviews-user_id}}',
            '{{%reviews}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-reviews-user_id}}',
            '{{%reviews}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-reviews-executor_id}}',
            '{{%reviews}}'
        );

        // drops index for column `executor_id`
        $this->dropIndex(
            '{{%idx-reviews-executor_id}}',
            '{{%reviews}}'
        );

        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-reviews-task_id}}',
            '{{%reviews}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-reviews-task_id}}',
            '{{%reviews}}'
        );

        $this->dropTable('{{%reviews}}');
    }
}
