<?php

namespace bariew\postModule\controllers;

use Yii;
use bariew\postModule\models\Category;
use bariew\postModule\models\SearchCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    public $layout = 'menu';
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
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
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = $this->findModel(null);
        $root = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->appendTo($root)) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
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
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithChildren();

        return $this->redirect(['index']);
    }
    
    public function actionTreeMove($id)
    {
        $child = $this->findModel($id);
        $parent = $this->findModel(\Yii::$app->request->post('pid'));
        $position = \Yii::$app->request->post('position');
        if ((!$leaves = $parent->leaves()->all()) || ($position == 0)) {
            $child->prependTo($parent);
        } else if(count($leaves) <= $position) {
            $child->insertAfter(end($leaves));
        } else {
            $child->insertAfter($leaves[$position-1]);
        }
    }
    
    public function actionTreeUpdate($id)
    {
        $model = $this->findModel($id);
        $attributes = [
            'name' => \Yii::$app->request->post('attributes')['title']
        ];
        if ($model->load($attributes, '') && $model->save()) {
            return true;
        }
        throw new \yii\web\BadRequestHttpException();
    }
    
    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer|array|null $condition
     * @param boolean $search
     * @return Category|SearchCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($condition, $search = false)
    {
        $class = preg_replace('/^(.*)(controllers).*$/', '$1models', get_class($this))
            . '\\'. ($search ? 'SearchCategory' : 'Category');
        if (!$condition) {
            $model = new $class();
        } else if (!$model = $class::findOne($condition)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }
}
