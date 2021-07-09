<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%users}}`
 * - `{{%categories}}`
 * - `{{%cities}}`
 */
class m210709_192622_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'dt_add' => $this->datetime()->notNull(),
            'deadline' => $this->datetime()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'executor_id' => $this->integer()->null(),
            'category_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'status' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'cost' => $this->integer()->null(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-tasks-user_id}}',
            '{{%tasks}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tasks-user_id}}',
            '{{%tasks}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `executor_id`
        $this->createIndex(
            '{{%idx-tasks-executor_id}}',
            '{{%tasks}}',
            'executor_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tasks-executor_id}}',
            '{{%tasks}}',
            'executor_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-tasks-category_id}}',
            '{{%tasks}}',
            'category_id'
        );

        // add foreign key for table `{{%categories}}`
        $this->addForeignKey(
            '{{%fk-tasks-category_id}}',
            '{{%tasks}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );

        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx-tasks-city_id}}',
            '{{%tasks}}',
            'city_id'
        );

        // add foreign key for table `{{%cities}}`
        $this->addForeignKey(
            '{{%fk-tasks-city_id}}',
            '{{%tasks}}',
            'city_id',
            '{{%cities}}',
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
            '{{%fk-tasks-user_id}}',
            '{{%tasks}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-tasks-user_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-tasks-executor_id}}',
            '{{%tasks}}'
        );

        // drops index for column `executor_id`
        $this->dropIndex(
            '{{%idx-tasks-executor_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%categories}}`
        $this->dropForeignKey(
            '{{%fk-tasks-category_id}}',
            '{{%tasks}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-tasks-category_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%cities}}`
        $this->dropForeignKey(
            '{{%fk-tasks-city_id}}',
            '{{%tasks}}'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx-tasks-city_id}}',
            '{{%tasks}}'
        );

        $this->dropTable('{{%tasks}}');
    }
}
