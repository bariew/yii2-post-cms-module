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
class TreeCreateAction extends Action
{
    public $view = 'create';
    public $redirectAction = 'view';

    /**
     * @inheritdoc
     */
    public function run($id)
    {
        $model = $this->controller->findModel(null);
        $root = $this->controller->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->appendTo($root)) {
            return $this->controller->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->controller->render('create', [
                'model' => $model,
            ]);
        }
    }
}