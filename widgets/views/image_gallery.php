<?php
use yii\helpers\Html;
use bariew\postModule\models\Item;

/**
 * @var Item $model
 */
; ?>
<?php foreach ($items as $name => $link): ?>
    <div class="image-item img-thumbnail">
        <img src="<?= $link; ?>" />
        <?php if($admin): ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>',
            ["file-delete", 'id' => $model->id, 'name' => $name],
            [
                'onclick' => '$.post($(this).prop("href")); return false',
                'class' => 'pull-right'
            ]
        ); ?>
        <?php endif; ?>
        <div class="clearfix"></div>
        <?= Html::tag('div', $name, [
            'contentEditable' => true,
            'data-href' => \yii\helpers\Url::to(['file-rename', 'id' => $model->id, 'name' => $name]),
            'onchange' => '$.post($(this).data("href"), {newName : $(this).html()}); return false',
            'onblur' => '$(this).trigger("change");'
        ]); ?>
    </div>
<?php endforeach; ?>

