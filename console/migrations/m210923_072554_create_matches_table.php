<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%match}}`.
 */
class m210923_072554_create_matches_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%matches}}', [
            'id' => $this->primaryKey(),
            'date' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%matches}}');
    }
}
