<?php
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel bariew\postModule\models\SearchItem */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'columns' => [
        'title',
        'is_active:boolean',
        'created_at:datetime',
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>