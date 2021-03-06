<?php
/**
 * Item class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\postModule\models;

use Yii;
use \yii\db\ActiveRecord;
use \bariew\yii2Tools\behaviors\FileBehavior;
use bariew\postModule\components\CategoryToItemBehavior;
use yii\db\ActiveQuery;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $brief
 * @property string $content
 * @property integer $is_active
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $image
 *
 * @method FileBehavior getRemoveLink
 * @method FileBehavior getFileLink
 * @method FileBehavior getFilePositionLink
 * @method FileBehavior linkList
 * @method FileBehavior deleteFile
 * @method FileBehavior renameFile
 *
 */
class Item extends ActiveRecord
{
    const SCENARIO_ADMIN = 'admin';
    const SCENARIO_USER = 'user';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_item';
    }

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
            [['categoryIds'], 'safe', 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_USER]],
            ['user_id', 'required', 'on' => self::SCENARIO_ADMIN],
            ['user_id', 'integer', 'on' => self::SCENARIO_ADMIN],
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
            'categoryToItem' => [
                'class' => CategoryToItemBehavior::className()
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        switch ($this->scenario) {
            case self::SCENARIO_USER :
                $this->user_id = Yii::$app->user->id;
                break;
            case self::SCENARIO_DEFAULT:
                $this->is_active = 1;
                break;
        }
    }

    /**
     * Gets search query according to model scenario.
     * @param array $params search params key=>value
     * @return ActiveQuery
     */
    public function search($params = [])
    {
        return $this::find()->andFilterWhere(array_merge($this->attributes, $params));
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('modules/post', 'ID'),
            'user_id' => Yii::t('modules/post', 'User ID'),
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
        return self::find()->andWhere(['is_active' => 1]);
    }

    /**
     * is_active field available values.
     * @return array
     */
    public static function activeList()
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
        $moduleName = \bariew\postModule\Module::moduleName($this);
        $user_id = $this->getAttribute('user_id') ? : Yii::$app->user->id;
        return "@app/web/files/{$user_id}/{$moduleName}/"
            . $this->formName() . '/' . $this->id; 
    }
}
