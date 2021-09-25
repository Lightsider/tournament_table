<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "team_matches".
 *
 * @property int $id
 * @property int $match_id
 * @property int $team_id
 * @property int|null $goals
 *
 * @property Match $match
 * @property Team $team
 */
class TeamMatch extends ActiveRecord
{
    const RESULT_WIN = 3;
    const RESULT_DEAD_HEAT = 1;
    const RESULT_LOSE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team_matches';
    }

    public static function deleteOldResult(TeamMatch $teamMatch1, TeamMatch $teamMatch2)
    {
        $team1 = $teamMatch1->team;
        $team2 = $teamMatch2->team;

        if ($teamMatch1->goals > $teamMatch2->goals) {
            $team1->score -= TeamMatch::RESULT_WIN;
            $team2->score -= TeamMatch::RESULT_LOSE;
        } elseif ($teamMatch1->goals < $teamMatch2->goals) {
            $team1->score -= TeamMatch::RESULT_LOSE;
            $team2->score -= TeamMatch::RESULT_WIN;
        } else {
            $team1->score -= TeamMatch::RESULT_DEAD_HEAT;
            $team2->score -= TeamMatch::RESULT_DEAD_HEAT;
        }
        $team1->save();
        $team2->save();
    }

    public static function setNewResult(TeamMatch $teamMatch1, TeamMatch $teamMatch2)
    {
        $team1 = $teamMatch1->team;
        $team2 = $teamMatch2->team;

        if ($teamMatch1->goals > $teamMatch2->goals) {
            $team1->score += TeamMatch::RESULT_WIN;
            $team2->score += TeamMatch::RESULT_LOSE;
        } elseif ($teamMatch1->goals < $teamMatch2->goals) {
            $team1->score += TeamMatch::RESULT_LOSE;
            $team2->score += TeamMatch::RESULT_WIN;
        } else {
            $team1->score += TeamMatch::RESULT_DEAD_HEAT;
            $team2->score += TeamMatch::RESULT_DEAD_HEAT;
        }
        $team1->save();
        $team2->save();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['match_id', 'team_id'], 'required'],
            [['match_id', 'team_id', 'goals'], 'integer'],
            [
                ['match_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Match::className(),
                'targetAttribute' => ['match_id' => 'id']
            ],
            [
                ['team_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Team::className(),
                'targetAttribute' => ['team_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'match_id' => 'Match ID',
            'team_id' => 'Team ID',
            'goals' => 'Goals',
        ];
    }

    /**
     * Gets query for [[Match]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMatch()
    {
        return $this->hasOne(Match::class, ['id' => 'match_id']);
    }

    /**
     * Gets query for [[Team]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['id' => 'team_id']);
    }
}
