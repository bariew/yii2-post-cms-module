<?php

namespace bariew\postModule\controllers;

use bariew\abstractModule\models\AbstractModel;
use bariew\nodeTree\ARTreeMenuWidget;
use bariew\postModule\actions\TreeCreateAction;
use bariew\postModule\actions\TreeDeleteAction;
use bariew\postModule\actions\TreeMoveAction;
use bariew\postModule\actions\TreeUpdateAction;
use bariew\postModule\Module;
use Yii;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends ItemController
{
    public $layout = 'menu';

    public function actions()
    {
        return array_merge(parent::actions(), [
            'create' => TreeCreateAction::className(),
            'delete' => TreeDeleteAction::className(),
            'tree-move' => TreeMoveAction::className(),
            'tree-update' => TreeUpdateAction::className(),
        ]);
    }

    public function getMenu()
    {
        $moduleName = AbstractModel::moduleName(static::className());
        $model = $this->findModel();
        $uniqueKey = 0;
        $items = $model::find()->orderBy(['lft' => SORT_ASC])->asArray()->all();;
        foreach ($items as &$item) {
            $uniqueKey++;
            $nodeId = $uniqueKey . '-id-' . $item['id'];
            $item['nodeAttributes'] = [
                'id'    => $nodeId,
                'text'  => $item['name'],
                'type'  => 'folder',
                'active'=> \Yii::$app->request->get('id') == $item['id'],
                'a_attr'=> [
                    'data-id' => $nodeId,
                    'href'    => ["/{$moduleName}/category/update", 'id' => $item['id']]
                ]
            ];
        }
        $treeWidget = new ARTreeMenuWidget([
            'items' => $items,
            'view' => 'nested'
        ]);
        return $treeWidget->run();
    }
}
