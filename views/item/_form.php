<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model bariew\postModule\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'image[]')->fileInput(['multiple' => true]) ?>
    <?= \bariew\postModule\widgets\ImageGallery::widget(['model' => $model, 'field' => 'thumb1']); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'categories')->widget(Select2::className(), [
        'data' => $model->categoriesList(),
        'options' => ['placeholder' => false, 'multiple' => true,]
    ]);?>

    <?= $form->field($model, 'brief')->widget(\yii\imperavi\Widget::className(), [
        'options'   => [
            'minHeight'                => 100,
            'fileUpload'               => Url::toRoute(['file-upload', 'attr' => 'brief', 'id' => $model->id]),
            'imageUpload'              => Url::toRoute(['image-upload', 'attr' => 'brief', 'id' => $model->id]),
            'imageGetJson'             => Url::toRoute(['image-list', 'attr' => 'brief', 'id' => $model->id]),
            'imageUploadErrorCallback' => new \yii\web\JsExpression('function(json) { alert(json.error); }'),
            'fileUploadErrorCallback'  => new \yii\web\JsExpression('function(json) { alert(json.error); }'),
        ]
    ]) ?>

    <?= $form->field($model, 'content')->widget(\yii\imperavi\Widget::className(), [
        'options'   => [
            'minHeight'                => 300,
            'fileUpload'               => Url::toRoute(['file-upload', 'attr' => 'content', 'id' => $model->id]),
            'imageUpload'              => Url::toRoute(['image-upload', 'attr' => 'content', 'id' => $model->id]),
            'imageGetJson'             => Url::toRoute(['image-list', 'attr' => 'content', 'id' => $model->id]),
            'imageUploadErrorCallback' => new \yii\web\JsExpression('function(json) { alert(json.error); }'),
            'fileUploadErrorCallback'  => new \yii\web\JsExpression('function(json) { alert(json.error); }'),
        ]
    ]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('modules/post', 'Create') : Yii::t('modules/post', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
