<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_files}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%files}}`
 */
class m210709_192614_create_users_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_files}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'file_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-users_files-user_id}}',
            '{{%users_files}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_files-user_id}}',
            '{{%users_files}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `file_id`
        $this->createIndex(
            '{{%idx-users_files-file_id}}',
            '{{%users_files}}',
            'file_id'
        );

        // add foreign key for table `{{%files}}`
        $this->addForeignKey(
            '{{%fk-users_files-file_id}}',
            '{{%users_files}}',
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
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-users_files-user_id}}',
            '{{%users_files}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-users_files-user_id}}',
            '{{%users_files}}'
        );

        // drops foreign key for table `{{%files}}`
        $this->dropForeignKey(
            '{{%fk-users_files-file_id}}',
            '{{%users_files}}'
        );

        // drops index for column `file_id`
        $this->dropIndex(
            '{{%idx-users_files-file_id}}',
            '{{%users_files}}'
        );

        $this->dropTable('{{%users_files}}');
    }
}
