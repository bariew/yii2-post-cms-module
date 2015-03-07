<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model bariew\postModule\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <?= $form->field($model, 'image[]')->fileInput(['multiple' => true]) ?>
    <?= \bariew\postModule\widgets\ImageGallery::widget(['model' => $model, 'field' => 'thumb1']); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <div class="form-group required">
        <?php echo yii\imperavi\Widget::widget([
            'model' => $model,
            'attribute' => 'brief',
            'options'   => [
                'minHeight'                => 100,
                'fileUpload'               => Url::toRoute(['file-upload', 'attr' => 'brief', 'id' => $model->id]),
                'imageUpload'              => Url::toRoute(['image-upload', 'attr' => 'brief', 'id' => $model->id]),
                'imageGetJson'             => Url::toRoute(['image-list', 'attr' => 'brief', 'id' => $model->id]),
                'imageUploadErrorCallback' => new \yii\web\JsExpression('function(json) { alert(json.error); }'),
                'fileUploadErrorCallback'  => new \yii\web\JsExpression('function(json) { alert(json.error); }'),
             ]
        ]);?>
        <?php if ($model->hasErrors('content')): ?>
        <div class="has-error">
            <?php echo \yii\helpers\Html::error($model, 'brief', $form->field($model, 'brief')->errorOptions); ?>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="form-group required">
        <?php echo yii\imperavi\Widget::widget([
            'model' => $model,
            'attribute' => 'content',
            'options'   => [
                'minHeight'                => 300,
                'fileUpload'               => Url::toRoute(['file-upload', 'attr' => 'content', 'id' => $model->id]),
                'imageUpload'              => Url::toRoute(['image-upload', 'attr' => 'content', 'id' => $model->id]),
                'imageGetJson'             => Url::toRoute(['image-list', 'attr' => 'content', 'id' => $model->id]),
                'imageUploadErrorCallback' => new \yii\web\JsExpression('function(json) { alert(json.error); }'),
                'fileUploadErrorCallback'  => new \yii\web\JsExpression('function(json) { alert(json.error); }'),
             ]
        ]);?>
        <?php if ($model->hasErrors('content')): ?>
        <div class="has-error">
            <?php echo \yii\helpers\Html::error($model, 'content', $form->field($model, 'content')->errorOptions); ?>
        </div>
        <?php endif; ?>
    </div>
    
    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('modules/post', 'Create') : Yii::t('modules/post', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
