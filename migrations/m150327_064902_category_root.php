<?php

use yii\db\Migration;
use bariew\postModule\models\Category;

class m150327_064902_category_root extends Migration
{
    private $item = [
        'name' => 'Categories',
        'title' => 'Categories',
        'is_active' => 0
    ];

    public function up()
    {
        $root = new Category($this->item);
        $root->makeRoot();
    }

    public function down()
    {
        $this->delete(Category::tableName(), $this->item);
    }
}
