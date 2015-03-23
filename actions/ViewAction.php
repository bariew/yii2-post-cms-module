<?php
/**
 * ViewAction class file.
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
class ViewAction extends Action
{
    /**
     * @inheritdoc
     */
    public function run($id)
    {
        return $this->controller->render('view', [
            'model' => $this->controller->findModel($id),
        ]);
    }
}