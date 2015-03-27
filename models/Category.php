<?php

namespace bariew\postModule\models;

use bariew\postModule\components\NestedQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "post_category".
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property string $content
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $is_active
 *
 * @method NestedSetsBehavior makeRoot()
 * @method NestedSetsBehavior prependTo()
 * @method NestedSetsBehavior appendTo()
 * @method NestedSetsBehavior insertBefore()
 * @method NestedSetsBehavior insertAfter()
 * @method NestedSetsBehavior deleteWithChildren()
 * @method NestedSetsBehavior parents()
 * @method NestedSetsBehavior children()
 * @method NestedSetsBehavior prev()
 * @method NestedSetsBehavior next()
 * @method NestedSetsBehavior isRoot()
 * @method NestedSetsBehavior isLeaf()
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['lft', 'rgt', 'depth', 'is_active'], 'integer'],
            [['title', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('modules/post', 'ID'),
            'title' => Yii::t('modules/post', 'Title'),
            'name' => Yii::t('modules/post', 'Name'),
            'content' => Yii::t('modules/post', 'Content'),
            'lft' => Yii::t('modules/post', 'Lft'),
            'rgt' => Yii::t('modules/post', 'Rgt'),
            'depth' => Yii::t('modules/post', 'Depth'),
            'is_active' => Yii::t('modules/post', 'Is Active'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'tree' => ['class' => NestedSetsBehavior::className()],
        ];
    }

    /**
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return NestedQuery
     */
    public static function find()
    {
        return new NestedQuery(get_called_class());
    }
}
