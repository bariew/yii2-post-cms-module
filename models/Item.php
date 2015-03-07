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
 * @method FileBehavior linkList
 * @method FileBehavior deleteFile
 * @method FileBehavior renameFile
 *
 */
class Item extends ActiveRecord
{
    const SCENARIO_ADMIN = 'admin';
    
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
            ]
        ];
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
        ];
    }
    
    /**
     * Relative path for saving model files.
     * @return string path.
     */
    public function getStoragePath()
    {
        $moduleName = preg_match('/.*\\\\(\w+)\\\\models\\\\\w+$/', get_class($this), $matches)
            ? $matches[1] : 'post';
        $user_id = $this->user_id ? : Yii::$app->user->id;
        return "@app/web/files/{$user_id}/{$moduleName}/"
            . $this->formName() . '/' . $this->id; 
    }
}
