<?php

use common\models\Match;
use common\models\Team;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Matches');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="match-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Match'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date',
            [
                'attribute' => 'teams',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var Match $model */
                    return implode(', ', array_column(array_column($model->getTeamMatches()->with('team')->asArray()->all(), 'team'), 'name'));
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
