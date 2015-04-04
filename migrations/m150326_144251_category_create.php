<?php

use yii\db\Schema;
use yii\db\Migration;
use bariew\postModule\models\Category;
use bariew\postModule\models\CategoryToItem;
class m150326_144251_category_create extends Migration
{
    public function up()
    {
        $this->createTable(Category::tableName(), [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'name' => Schema::TYPE_STRING,
            'image' => Schema::TYPE_STRING,
            'content' => Schema::TYPE_TEXT,
            'lft' => Schema::TYPE_INTEGER,
            'rgt' => Schema::TYPE_INTEGER,
            'depth' => Schema::TYPE_INTEGER,
            'is_active' => Schema::TYPE_BOOLEAN,
        ]);
        $this->createTable(CategoryToItem::tableName(), [
            'category_id' => Schema::TYPE_INTEGER,
            'item_id' => Schema::TYPE_INTEGER
        ]);
        return true;
    }

    public function down()
    {
        $this->dropTable(CategoryToItem::tableName());
        $this->dropTable(Category::tableName());
        return true;
    }
}
