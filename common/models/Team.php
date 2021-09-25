<?php

namespace common\models;

use Yii;
use yii\bootstrap4\Html;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "teams".
 *
 * @property int $id
 * @property string $name
 * @property int|null $score
 * @property string|null $image
 *
 * @property TeamMatch[] $teamMatches
 */
class Team extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teams';
    }

    public static function columns()
    {
        $columns[] = [
            'attribute' => 'position',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var Team $model */
                return $model->position;
            },
        ];
        $columns[] = [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var Team $model */
                return '<p>'. Html::img(Url::toRoute($model->getImage()),[
                        'style' => 'width: 25px; height: 25px; margin-right: 5%'
                    ]) . $model->name . '</p>';
            },
        ];

        $columns[] = [
            'attribute' => 'matches',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var Team $model */
                return count($model->getTeamMatches()->all());
            },
        ];

        $columns[] = [
            'attribute' => 'goals',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var Team $model */
                return $model->goals;
            },
        ];

        $columns[] = [
            'attribute' => 'score',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var Team $model */
                return $model->score;
            },
        ];

        return $columns;
    }

    public function getImage()
    {
        return str_replace('@frontend/web', '', !empty($this->image)
            ? $this->image : Yii::$app->params['defaultTeamLogo']);
    }

    /**
     * Gets query for [[TeamMatches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeamMatches()
    {
        return $this->hasMany(TeamMatch::class, ['team_id' => 'id']);
    }

    public function getAllGoals()
    {
        return array_sum(
            array_column($this->getTeamMatches()->select('goals')->asArray()->all(), 'goals')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['score'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['goals'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'score' => 'Score',
            'image' => 'Image',
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['position']);
    }

    public function getGoals() {
        return $this->getAllGoals();
    }
}
