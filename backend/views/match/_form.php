<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Match */
/* @var $form yii\widgets\ActiveForm */
/* @var $allTeams array */
?>

<div class="match-form">
    <?php $form = ActiveForm::begin(['class' => 'form']); ?>
    <div class="col-3">
        <div class="row">
            <h2>Match</h2>
            <div class="col-12">
                <?= $form->field($model, 'date')->input('datetime-local'); ?>
            </div>
        </div>
    </div>

    <h2>Team 1</h2>
    <div class="col-12">
        <div class="row form-group">
            <div class="col-6">
                <?= $form->field($model, 'team1')->dropDownList( $allTeams, [
                    'class' => 'form-control',
                ]) ?>
            </div>

            <div class="col-3">
                <?= $form->field($model, 'score1')->textInput([
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>
    </div>

    <h2>Team 2</h2>

    <div class="col-12">
        <div class="row form-group">
            <div class="col-6">
                <?= $form->field($model, 'team2')->dropDownList( $allTeams, [
                    'class' => 'form-control',
                ]) ?>
            </div>

            <div class="col-3">
                <?= $form->field($model, 'score2')->textInput([
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
