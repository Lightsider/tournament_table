<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%teams}}`.
 */
class m210923_072113_create_teams_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%teams}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'score' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%teams}}');
    }
}
