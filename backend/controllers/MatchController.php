<?php

namespace backend\controllers;

use backend\models\forms\MatchForm;
use common\models\Match;
use common\models\Team;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MatchController implements the CRUD actions for Match model.
 */
class MatchController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Match models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Match::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Match model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Match model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MatchForm();
        $allTeams = ArrayHelper::map(Team::find()->all(), 'id', 'name');

        if ($this->request->isPost) {
            try {
                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\Throwable $e) {
                \Yii::$app->session->addFlash('error', 'Error saving data. Try again later');
                //todo log message
            }
        }

        return $this->render('create', [
            'model' => $model,
            'allTeams' => $allTeams,
        ]);
    }

    /**
     * Updates an existing Match model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = MatchForm::fromModel($model);
        $allTeams = ArrayHelper::map(Team::find()->all(), 'id', 'name');

        try {
            if ($this->request->isPost && $form->load($this->request->post()) && $form->save($id)) {
                \Yii::$app->session->addFlash('success', 'Data successfully saved.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } catch (\Throwable $e) {
            \Yii::$app->session->addFlash('error', 'Error saving data. Try again later');
            //todo log message
        }

        return $this->render('update', [
            'model' => $form,
            'allTeams' => $allTeams,
        ]);
    }

    /**
     * Deletes an existing Match model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Match model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Match the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Match::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
