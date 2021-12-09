<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bookmarks}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%users}}`
 */
class m211201_013223_create_bookmarks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bookmarks}}', [
            'id' => $this->primaryKey(),
            'follower_id' => $this->integer()->notNull(),
            'favorite_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `follower_id`
        $this->createIndex(
            '{{%idx-bookmarks-follower_id}}',
            '{{%bookmarks}}',
            'follower_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-bookmarks-follower_id}}',
            '{{%bookmarks}}',
            'follower_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `favorite_id`
        $this->createIndex(
            '{{%idx-bookmarks-favorite_id}}',
            '{{%bookmarks}}',
            'favorite_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-bookmarks-favorite_id}}',
            '{{%bookmarks}}',
            'favorite_id',
            '{{%users}}',
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
            '{{%fk-bookmarks-follower_id}}',
            '{{%bookmarks}}'
        );

        // drops index for column `follower_id`
        $this->dropIndex(
            '{{%idx-bookmarks-follower_id}}',
            '{{%bookmarks}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-bookmarks-favorite_id}}',
            '{{%bookmarks}}'
        );

        // drops index for column `favorite_id`
        $this->dropIndex(
            '{{%idx-bookmarks-favorite_id}}',
            '{{%bookmarks}}'
        );

        $this->dropTable('{{%bookmarks}}');
    }
}
