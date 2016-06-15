<?php
/**
 * Item class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\postModule\models;

use bariew\abstractModule\models\AbstractModel;
use bariew\postModule\Module;
use bariew\yii2Tools\behaviors\RelationViaBehavior;
use bariew\yii2Tools\validators\ListValidator;
use Yii;
use yii\base\DynamicModel;
use \yii\db\ActiveRecord;
use \bariew\yii2Tools\behaviors\FileBehavior;
use yii\db\ActiveQuery;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 * @property integer $id
 * @property integer $owner_id
 * @property string $title
 * @property string $brief
 * @property string $content
 * @property integer $is_active
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $image
 *
 * @mixin FileBehavior
 *
 */
class Item extends AbstractModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'brief', 'content'], 'required'],
            [['is_active'], 'boolean'],
            [['brief', 'content'], 'string'],
            [['title'], 'string', 'max' => 255],
            ['image', 'image', 'maxFiles' => 10],
            ['categories', ListValidator::className(),
                'model' => $this,
                'when' => function($model){ return $model instanceof DynamicModel;}],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            'fileBehavior' => [
                'class' => FileBehavior::className(),
                'storage' => [$this, 'getStoragePath'],
                'fileField' => 'image',
                'imageSettings' => [
                    'thumb1' => ['method' => 'thumbnail', 'width' => 50, 'height' => 50],
                    'thumb2' => ['method' => 'thumbnail', 'width' => 100, 'height' => 100],
                    'thumb3' => ['method' => 'thumbnail', 'width' => 200, 'height' => 200],
                ]
            ],
            [
                'class' => RelationViaBehavior::className(),
                'relations' => ['categories']
            ]
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategoryToItems()
    {
        return static::hasMany(CategoryToItem::childClass(), ['item_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategories()
    {
        return static::hasMany(Category::childClass(), ['id' => 'category_id'])
            ->via('categoryToItems');
    }

    /**
     * @return array
     */
    public function categoriesList()
    {
        $class = Category::childClass();
        return $class::find()->indexBy('id')->select('name')->column();
    }

    /**
     * Gets search query.
     * @param array $params search params key=>value
     * @return ActiveQuery
     */
    public function search($params = [])
    {
        return self::find()->andFilterWhere(array_merge($this->attributes, $params));
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('modules/post', 'ID'),
            'owner_id' => Yii::t('modules/post', 'Owner ID'),
            'title' => Yii::t('modules/post', 'Title'),
            'brief' => Yii::t('modules/post', 'Brief'),
            'content' => Yii::t('modules/post', 'Content'),
            'is_active' => Yii::t('modules/post', 'Is Active'),
            'created_at' => Yii::t('modules/post', 'Created At'),
            'updated_at' => Yii::t('modules/post', 'Updated At'),
            'image' => Yii::t('modules/post', 'Image'),
            'categoryIds' => Yii::t('modules/post', 'Category list'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public static function active()
    {
        return static::find()->andWhere(['is_active' => 1]);
    }

    /**
     * is_active field available values.
     * @return array
     */
    public static function isActiveList()
    {
        return [
            0 => Yii::t('modules/post', 'No'),
            1 => Yii::t('modules/post', 'Yes'),
        ];
    }

    /**
     * Relative path for saving model files.
     * @return string path.
     */
    public function getStoragePath()
    {
        $moduleName = AbstractModel::moduleName(static::className());
        $owner_id = $this->getAttribute('owner_id') ? : Yii::$app->user->id;
        return "@app/web/files/{$owner_id}/{$moduleName}/"
            . $this->formName() . '/' . $this->id; 
    }
}
