<?php

/**
 * @var yii\web\View $this
 * @var yii\base\Model $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var array $columns
 */

use yii\grid\GridView;

$this->title = 'Турнирная таблица';
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
]); ?>