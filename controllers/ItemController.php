<?php
/**
 * ItemController class file.
 * @copyright (c) 2015, Bariev Pavel
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\postModule\controllers;

use Yii;
use bariew\postModule\models\Item;
use bariew\postModule\models\SearchItem;
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
       // echo $this->storagePath();exit;
        return [
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
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = $this->findModel(null, true);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = $this->findModel(null);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer|array|null $condition
     * @param boolean $search
     * @return Item|SearchItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($condition, $search = false)
    {
        $class = preg_replace('/^(.*)(controllers).*$/', '$1models', get_class($this))
            . '\\'. ($search ? 'SearchItem' : 'Item');
       
        if (!$condition) {
            $model = new $class();
        } else if (!$model = $class::findOne($condition)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->scenario = $class::SCENARIO_ADMIN;
        return $model;
    }
}
