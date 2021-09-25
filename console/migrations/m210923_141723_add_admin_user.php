<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m210923_141723_add_admin_user
 */
class m210923_141723_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $transaction = $this->getDb()->beginTransaction();
        $user = \Yii::createObject([
            'class' => User::class,
            'scenario' => 'create',
            'email' => 'admin',
            'username' => 'admin@admin.com',
            'password' => 'admin',
        ]);
        if (!$user->insert(false)) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        User::deleteAll(['email' => 'admin@admin.com']);
    }
}
