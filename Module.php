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
        $class = static::getClass($class, $formName, $replacements);
        return new $class($initData);
    }

    /**
     * Gets class name for a model that inherits current modules model.
     * @param $className
     * @param null $formName
     * @param array $replacements
     * @return \yii\db\ActiveRecord
     */
    public static function getClass($className, $formName = null, $replacements = [])
    {
        $class = $formName
            ? preg_replace('/(.*\\\\)\w+$/', '$1' . $formName, $className)
            : $className;
        return str_replace(array_keys($replacements), array_values($replacements), $class);
    }

    public static function getName($className)
    {
        return preg_replace('#.*\\\\(\w+)\\\\models\\\\\w+$#','$1', $className);
    }
}
