<?php

namespace bariew\postModule;
use yii\db\ActiveRecord;

class Module extends \yii\base\Module
{
    public $params = [
        'menu'  => [
            'label'    => 'Post',
            'items' => [
                [
                    'label'    => 'Admin posts',
                    'url' => ['/post/item/index']
                ],
                [
                    'label'    => 'Admin categories',
                    'url' => ['/post/category/index']
                ],
                [
                    'label'    => 'My posts',
                    'url' => ['/post/user-item/index']
                ],
            ]
        ]
    ];
    
    public static function moduleName($object)
    {
        return preg_match('/modules\\\\(\w+)\\\\.*/', 
                get_class($object), $matches)
            ? $matches[1] : 'post';        
    }

    /**
     *
     * @param $model
     * @param string $formName
     * @param array $replacements
     * @param array $initData
     * @return object $model
     */
    public static function getModel($model, $formName = null, $replacements = [], $initData = [])
    {
        $class = is_string($model) ? $model : get_class($model);
        $class = $formName
            ? preg_replace('/(.*\\\\)\w+$/', '$1' . $formName, $class)
            : $class;
        $class = str_replace(array_keys($replacements), array_values($replacements), $class);
        return new $class($initData);
    }
}
