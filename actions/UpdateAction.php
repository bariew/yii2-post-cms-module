<?php
/**
 * UpdateAction class file.
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
class UpdateAction extends Action
{
    public $view = 'update';
    public $redirectAction = 'view';

    /**
     * @inheritdoc
     */
    public function run($id)
    {
        $model = $this->controller->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('modules/post', 'Successfully updated.'));
            return $this->controller->redirect([$this->redirectAction, 'id' => $model->id]);
        } else {
            return $this->controller->render($this->view, compact('model'));
        }
    }
}