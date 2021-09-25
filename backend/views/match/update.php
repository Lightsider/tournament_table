<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Match */

$this->title = Yii::t('app', 'Update Match: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Matches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="match-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allTeams' => $allTeams,
    ]) ?>

</div>
