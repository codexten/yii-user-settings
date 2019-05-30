<?php

namespace codextend\yii\user\settings\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_setting}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class M190530162912Create_user_setting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_setting}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'key' => $this->string(50),
            'value' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer
(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_setting-user_id}}',
            '{{%user_setting}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_setting-user_id}}',
            '{{%user_setting}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_setting-user_id}}',
            '{{%user_setting}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_setting-user_id}}',
            '{{%user_setting}}'
        );

        $this->dropTable('{{%user_setting}}');
    }
}
