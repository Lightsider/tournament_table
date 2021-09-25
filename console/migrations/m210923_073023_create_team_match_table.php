<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%team_matches}}`.
 */
class m210923_073023_create_team_match_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%team_matches}}', [
            'id' => $this->primaryKey(),
            'match_id' => $this->integer()->notNull(),
            'team_id' => $this->integer()->notNull(),
            'goals' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-team_matches-match_id' ,
            '{{%team_matches}}',
            'match_id'
        );

        $this->createIndex(
            'idx-team_matches-team_id' ,
            '{{%team_matches}}',
            'team_id'
        );

        $this->addForeignKey(
            'fk_team_matches-match_id',
            '{{%team_matches}}',
            'match_id',
            '{{%matches}}',
            'id'
        );
        $this->addForeignKey(
            'fk_team_matches-team_id',
            '{{%team_matches}}',
            'team_id',
            '{{%teams}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%team_matches}}');
    }
}
