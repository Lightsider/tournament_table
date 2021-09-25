<?php

use yii\db\Migration;

/**
 * Class m210923_142854_add_image_to_team_table
 */
class m210923_142854_add_image_to_team_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%teams}}', 'image',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%teams}}', 'image');
    }
}
