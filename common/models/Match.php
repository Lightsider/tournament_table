<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "matches".
 *
 * @property int $id
 * @property string|null $date
 *
 * @property TeamMatch[] $teamMatches
 */
class Match extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'matches';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[TeamMatches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeamMatches()
    {
        return $this->hasMany(TeamMatch::class, ['match_id' => 'id']);
    }
}
