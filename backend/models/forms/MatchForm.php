<?php

namespace backend\models\forms;

use common\models\Match;
use common\models\TeamMatch;
use http\Exception\RuntimeException;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Match form
 */
class MatchForm extends Model
{
    public $id;

    public $date;

    public $team1;

    public $score1;

    public $team2;

    public $score2;

    /**
     * @param Match $match
     * @return MatchForm
     */
    public static function fromModel(Match $match): MatchForm
    {
        $form = new self();
        $form->id = $match->id;
        $form->date = (new \DateTime($match->date))->format('Y-m-d\TH:i');
        list($teamMatch1, $teamMatch2) = $match->getTeamMatches()->all();
        /**
         * @var TeamMatch $teamMatch1
         * @var TeamMatch $teamMatch2
         */
        $form->team1 = $teamMatch1->team_id;
        $form->score1 = $teamMatch1->goals;

        $form->team2 = $teamMatch2->team_id;
        $form->score2 = $teamMatch2->goals;
        return $form;
    }

    public function formName()
    {
        return 'MatchForm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'team1', 'team2', 'score1', 'score2'], 'required'],
            [['score1', 'score2'], 'integer'],
            [
                'team1',
                'compare',
                'compareAttribute' => 'team2',
                'operator' => '!=',
                'message' => 'Please choose a different teams'
            ],
        ];
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Throwable
     */
    public function save(int $id = 0): int
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($id === 0) {
                $match = new Match();
                $teamMatch1 = new TeamMatch();
                $teamMatch2 = new TeamMatch();
            } else {
                $match = Match::findOne($id);
                list($teamMatch1, $teamMatch2) = $match->getTeamMatches()->all();

                TeamMatch::deleteOldResult($teamMatch1, $teamMatch2);
            }

            $match->date = $this->date;
            $teamMatch1->team_id = $this->team1;
            $teamMatch1->goals = $this->score1;
            $teamMatch2->team_id = $this->team2;
            $teamMatch2->goals = $this->score2;
            $teamMatch2->goals = $this->score2;

            TeamMatch::setNewResult($teamMatch1, $teamMatch2);
            $match->save();
            $teamMatch1->match_id = $match->id;
            $teamMatch1->save();
            $teamMatch2->match_id = $match->id;
            $teamMatch2->save();

            $transaction->commit();

            $this->id = $match->id;
            return $match->id;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
