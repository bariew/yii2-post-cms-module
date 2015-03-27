<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 27.03.15
 * Time: 11:28
 */

namespace bariew\postModule\widgets;


use bariew\nodeTree\ARTreeMenuWidget;
use bariew\postModule\models\Category;
use yii\base\Widget;

class CategoryMenu extends Widget
{
    public static $uniqueKey = 0;
    public $actionPath = '/post/category/update';

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
        $items = Category::find()->orderBy(['lft' => SORT_ASC])->asArray()->all();;
        foreach ($items as &$item) {
            $uniqueKey = self::$uniqueKey++;
            $nodeId = $uniqueKey . '-id-' . $item['id'];
            $item['nodeAttributes'] = [
                'id'    => $nodeId,
                'text'  => $item['name'],
                'type'  => 'folder',
                'a_attr'=> [
                    'data-id'   => $nodeId,
                    'href'    => [$this->actionPath, 'id' => $item['id']]
                ]
            ];
        }
        return $items;
    }
}