<?php
/**
 * CreateAction class file.
 * @copyright (c) 2015, bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\postModule\actions;

use yii\base\Action;
use bariew\postModule\models\SearchItem;
use Yii;
use bariew\postModule\controllers\ItemController;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 * @property ItemController $controller
 */
class TreeUpdateAction extends Action
{
    /**
     * @inheritdoc
     */
    public function run($id)
    {
        $model = $this->controller->findModel($id);
        $attributes = [
            'name' => \Yii::$app->request->post('attributes')['title']
        ];
        if ($model->load($attributes, '') && $model->save()) {
            return true;
        }
        throw new \yii\web\BadRequestHttpException();
    }
}