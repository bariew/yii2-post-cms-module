<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel bariew\postModule\models\Category */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('modules/post', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'name',
            [
                'attribute' => 'is_active',
                'format' => 'boolean',
                'filter' => Html::activeDropDownList($searchModel, 'is_active', $searchModel::activeList(), [
                    'class' => 'form-control',
                    'prompt' => ''
                ])
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
