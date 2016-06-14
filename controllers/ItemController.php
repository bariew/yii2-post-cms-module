<?php
/**
 * ItemController class file.
 * @copyright (c) 2015, Bariev Pavel
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\postModule\controllers;

use bariew\postModule\actions\CreateAction;
use bariew\postModule\actions\DeleteAction;
use bariew\postModule\actions\IndexAction;
use bariew\postModule\actions\UpdateAction;
use bariew\postModule\actions\ViewAction;
use bariew\postModule\Module;
use Yii;
use bariew\postModule\models\Item;
use bariew\postModule\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * For managing post items.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class ItemController extends Controller
{
    /**
     * @var string model uploaded files storage path.
     */
    protected $_storagePath;
    public $searchModelName = 'ItemSearch';
    public $modelName = 'Item';

    /**
     * Gets path to model uploaded files.
     * @return string path to model uploaded files.
     * @throws NotFoundHttpException
     */
    protected function storagePath()
    {
        if (\Yii::$app->controller != $this) {
            return false;
        }
        return $this->_storagePath
            ? $this->_storagePath
            : $this->_storagePath 
                = str_replace('@app/web', '', $this->findModel(Yii::$app->request->get('id'))->getStoragePath());
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'file-delete' => ['post'],
                    'file-rename' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function actions() 
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
            ],
            'view' => [
                'class' => ViewAction::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
            ],
            // Imperavi files
            'file-upload'    => [
                'class'         => 'yii\imperavi\actions\FileUpload',
                'uploadPath'    => Yii::getAlias('@app/web' . $this->storagePath()),
                'uploadUrl'     => $this->storagePath()
            ],
            'image-upload'    => [
                'class'         => 'yii\imperavi\actions\ImageUpload',
                'uploadPath'    => Yii::getAlias('@app/web' . $this->storagePath()),
                'uploadUrl'     => $this->storagePath()
            ],
            'image-list'    => [
                'class'         => 'yii\imperavi\actions\ImageList',
                'uploadPath'    => Yii::getAlias('@app/web' . $this->storagePath()),
                'uploadUrl'     => $this->storagePath()
            ],
            //FileBehavior files
            'file-delete' => [
                'class' => \bariew\yii2Tools\actions\FileDeleteAction::className()
            ],
            'file-rename' => [
                'class' => \bariew\yii2Tools\actions\FileRenameAction::className()
            ]
        ];
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer|boolean $id
     * @param boolean $search
     * @return Item|ItemSearch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id = false, $search = false)
    {
        $model = Module::getModel(
            static::className(),
            ($search ? $this->searchModelName : $this->modelName),
            ['controllers' => 'models']
        );
        if ($id && (!$model = $model->search(compact('id'))->one())) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }
}
