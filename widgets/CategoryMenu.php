<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 27.03.15
 * Time: 11:28
 */

namespace bariew\postModule\widgets;

use bariew\postModule\Module;
use bariew\nodeTree\ARTreeMenuWidget;
use bariew\postModule\models\Category;
use yii\base\Widget;

class CategoryMenu extends Widget
{
    public static $uniqueKey = 0;

    public $view = 'nested';

    public function run()
    {
        $treeWidget = new ARTreeMenuWidget([
            'items' => $this->generateItems(),
            'view' => 'nested'
        ]);
        return $treeWidget->run();
    }

    protected function generateItems()
    {
        $moduleName = Module::moduleName($this);

        $model = Module::getModel($this, 'Category', ['widgets' => 'models']);

        $items = $model::find()->orderBy(['lft' => SORT_ASC])->asArray()->all();;
        foreach ($items as &$item) {
            $uniqueKey = self::$uniqueKey++;
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
        return $items;
    }
}