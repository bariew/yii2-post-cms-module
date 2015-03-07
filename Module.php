<?php

namespace bariew\postModule;

class Module extends \yii\base\Module
{
    public $params = [
        'menu'  => [
            'label'    => 'Post',
            'items' => [
                [
                    'label'    => 'Admin',
                    'url' => ['/post/item/index']
                ],
                [
                    'label'    => 'My post',
                    'url' => ['/post/user-item/index']
                ],
            ]
        ]
    ];
}
