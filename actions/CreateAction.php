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
class CreateAction extends Action
{
    public $view = 'create';
    public $redirectAction = 'view';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = $this->controller->findModel(null);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->controller->redirect([$this->redirectAction, 'id' => $model->id]);
        } else {
            return $this->controller->render($this->view, compact('model'));
        }
    }
}