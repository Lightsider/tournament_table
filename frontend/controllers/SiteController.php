<?php

namespace frontend\controllers;

use common\models\Team;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $columns = Team::columns();

        $teamQuery = Team::find()->select([
            'teams.*',
            '(
                select  sum(goals)
                from    team_matches
                where   team_matches.team_id = teams.id
            ) as goals',
            '(
               SELECT rank 
               from 
               (
                   select @rownum := @rownum + 1 AS rank, t2.id 
                   from teams t2, (SELECT @rownum := 0) r 
                   order by t2.score DESC 
               ) as rank_t where rank_t.id = teams.id
            ) as position',
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $teamQuery,
            'sort' => [
                'attributes' => [
                    'position',
                    'name',
                    'goals' => [
                        'asc' => ['goals' => SORT_ASC],
                        'desc' => ['goals' => SORT_DESC],
                    ],
                    'score'
                ],
                'defaultOrder' => [
                    'score' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'columns' => $columns,
        ]);
    }
}
