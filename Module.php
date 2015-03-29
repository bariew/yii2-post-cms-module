<?php

namespace bariew\postModule;

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
     * @param type $formName
     * @return ActiveRecord $model
     */
    public static function getModel($model, $formName)
    {
        $class = preg_replace('/(.*\\\\)\w+$/', '$1'.$formName, get_class($model));
        return new $class();
    }
}
