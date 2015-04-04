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
class TreeMoveAction extends Action
{
    /**
     * @inheritdoc
     */
    public function run($id)
    {
        $child = $this->controller->findModel($id);
        $parent = $this->controller->findModel(\Yii::$app->request->post('pid'));
        $position = \Yii::$app->request->post('position');
        if ((!$leaves = $parent->leaves()->all()) || ($position == 0)) {
            $child->prependTo($parent);
        } else if(count($leaves) <= $position) {
            $child->insertAfter(end($leaves));
        } else {
            $child->insertAfter($leaves[$position-1]);
        }
    }
}