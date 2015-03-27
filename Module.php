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
}
