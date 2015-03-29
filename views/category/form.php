<?php
echo \yii\jui\Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('modules/post', 'Settings'),
            'content' => $this->render('_form', compact('model')),
        ],
        [
            'label' => Yii::t('modules/post', 'Items'),
            'url' => ['item/index', 'SearchItem[category_id]' => $model->id],
            'visible'   => false
        ],
    ],
    'options' => ['tag' => 'div'],
    'itemOptions' => ['tag' => 'div'],
    'headerOptions' => ['class' => 'my-class'],
    'clientOptions' => ['collapsible' => false],
]);