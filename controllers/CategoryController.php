<?php

namespace bariew\postModule\controllers;

use bariew\postModule\actions\TreeCreateAction;
use bariew\postModule\actions\TreeDeleteAction;
use bariew\postModule\actions\TreeMoveAction;
use bariew\postModule\actions\TreeUpdateAction;
use bariew\postModule\Module;
use Yii;
use bariew\postModule\models\Category;
use bariew\postModule\models\SearchCategory;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends ItemController
{
    public $layout = 'menu';

    public $searchModelName = 'SearchCategory';
    public $modelName = 'Category';

    public function actions()
    {
        return array_merge(parent::actions(), [
            'create' => TreeCreateAction::className(),
            'delete' => TreeDeleteAction::className(),
            'tree-move' => TreeMoveAction::className(),
            'tree-update' => TreeUpdateAction::className(),
        ]);
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
        $model = Module::getModel(
            $this,
            ($search ? $this->searchModelName : $this->modelName),
            ['controllers' => 'models']
        );
        if ($condition && (!$model = $model::findOne($condition))) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }
}
