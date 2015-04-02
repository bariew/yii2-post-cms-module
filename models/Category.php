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
    public $items = [];

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
            [['is_active'], 'integer'],
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
    
    public function beforeDelete() 
    {
        if ($this->depth == 0) {
            throw new \BadMethodCallException(
                \Yii::t('modules/post', "Root category can not be deleted.")
            );
        }
        return parent::beforeDelete();
    }

    public function updateChildren($attributes)
    {
        $childrenIds = $this->children()->select(['id'])->column();
        return $this->updateAll($attributes, ['id' => $childrenIds]);
    }

    public static function activeItems($items)
    {
        $result = [];
        $exclude = [];
        foreach ($items as $k => $item) {
            if (!$item['is_active']) {
                $exclude[] = $item;
                continue;
            }
            if (self::isChildOfArray($exclude, $item)) {
                continue;
            }
            $result[$k] = $item;
        }
        return $result; // keys are kept!
    }

    public static function toTree($items)
    {
        $result = [];
        $parents = [];
        foreach ($items as $item) {
            $parents[$item['depth']][$item['lft']] = $item;
            if (!isset($parents[$item['depth']-1])) {
                $result[$item['lft']] = &$parents[$item['depth']][$item['lft']];
                continue;
            }
            end($parents[$item['depth']-1]);
            $key = key($parents[$item['depth']-1]);
            $parents[$item['depth']-1][$key]['items'][$item['lft']]
                = &$parents[$item['depth']][$item['lft']];
        }
        return $result;
    }

    public static function isChildOfArray($parents, $child)
    {
        foreach ((array) $parents as $parent) {
            if ($child['lft'] > $parent['lft']
                && $child['rgt'] < $parent['rgt']) {
                return true;
            }
        }
        return false;
    }
}
