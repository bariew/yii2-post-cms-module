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
    public $searchModelName = 'CategorySearch';
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
}
