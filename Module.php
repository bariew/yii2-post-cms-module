<?php

namespace bariew\postModule;

class Module extends \yii\base\Module
{
    /**
     * @var array for menu auto generation
     */
    public $params = [
        'menu'  => [
            'label'    => 'posts',
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

    public function init()
    {
        parent::init();
        $params = $this->params;
        array_walk_recursive($params, function(&$v){
            $v = is_array($v) ? $v : str_replace('post', $this->id, $v);
        });
        $this->params = $params;
    }

}
