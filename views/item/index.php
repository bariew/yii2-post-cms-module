
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel bariew\postModule\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('modules/post', 'Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

    <h1><?= Html::encode($this->title) ?>
        <?= Html::a(
            Yii::t('modules/post', 'Create Item'),
            ['create'],
            ['class' => 'btn btn-success pull-right']
        ) ?>
    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            \bariew\yii2Tools\helpers\GridHelper::listFormat($searchModel, 'is_active'),
            \bariew\yii2Tools\helpers\GridHelper::dateFormat($searchModel, 'created_at'),
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
