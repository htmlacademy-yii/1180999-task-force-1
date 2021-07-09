<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%cities}}`
 * - `{{%files}}`
 */
class m210709_192602_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'is_executor' => $this->tinyInteger()->notNull()->defaultValue(0),
            'dt_add' => $this->datetime()->notNull(),
            'last_active_time' => $this->datetime()->null(),
            'name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'contacts' => $this->string(255)->null(),
            'phone' => $this->string(255)->notNull(),
            'skype' => $this->string(255)->notNull(),
            'other_contacts' => $this->string(255)->null(),
            'birthday' => $this->datetime()->notNull(),
            'about_me' => $this->text()->notNull(),
            'notification_new_message' => $this->tinyInteger()->notNull()->defaultValue(0),
            'notification_task_action' => $this->tinyInteger()->notNull()->defaultValue(0),
            'failed_count' => $this->tinyInteger()->null()->defaultValue(0),
            'show_contacts' => $this->tinyInteger()->notNull()->defaultValue(0),
            'city_id' => $this->integer()->notNull(),
            'avatar_file_id' => $this->integer()->null(),
        ]);

        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx-users-city_id}}',
            '{{%users}}',
            'city_id'
        );

        // add foreign key for table `{{%cities}}`
        $this->addForeignKey(
            '{{%fk-users-city_id}}',
            '{{%users}}',
            'city_id',
            '{{%cities}}',
            'id',
            'CASCADE'
        );

        // creates index for column `avatar_file_id`
        $this->createIndex(
            '{{%idx-users-avatar_file_id}}',
            '{{%users}}',
            'avatar_file_id'
        );

        // add foreign key for table `{{%files}}`
        $this->addForeignKey(
            '{{%fk-users-avatar_file_id}}',
            '{{%users}}',
            'avatar_file_id',
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
        // drops foreign key for table `{{%cities}}`
        $this->dropForeignKey(
            '{{%fk-users-city_id}}',
            '{{%users}}'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx-users-city_id}}',
            '{{%users}}'
        );

        // drops foreign key for table `{{%files}}`
        $this->dropForeignKey(
            '{{%fk-users-avatar_file_id}}',
            '{{%users}}'
        );

        // drops index for column `avatar_file_id`
        $this->dropIndex(
            '{{%idx-users-avatar_file_id}}',
            '{{%users}}'
        );

        $this->dropTable('{{%users}}');
    }
}
