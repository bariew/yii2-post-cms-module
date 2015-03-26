<?php

namespace bariew\postModule\models;

use Yii;

/**
 * This is the model class for table "post_category_to_item".
 *
 * @property integer $category_id
 * @property integer $item_id
 */
class CategoryToItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_category_to_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'item_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => Yii::t('modules/post', 'Category ID'),
            'item_id' => Yii::t('modules/post', 'Item ID'),
        ];
    }
}
