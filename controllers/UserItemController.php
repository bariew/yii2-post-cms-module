<?php

namespace bariew\postModule\controllers;


/**
 * UserItemController implements the CRUD actions for Item model.
 */
class UserItemController extends ItemController
{
    /**
     * @inheritdoc
     */
    public function findModel($id, $search = false)
    {
        $condition = $id ? (['id' => $id, 'user_id' => \Yii::$app->user->id]) : null;
        $model = parent::findModel($condition, $search);
        $model->scenario = \yii\db\ActiveRecord::SCENARIO_DEFAULT;
        $model->user_id = \Yii::$app->user->id; // we need to rewrite search user_id params
        return $model;
    }
}
