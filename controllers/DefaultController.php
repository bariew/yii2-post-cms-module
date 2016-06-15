<?php
/**
 * UserItemController class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\postModule\controllers;
use bariew\postModule\actions\IndexAction;
use bariew\postModule\actions\ViewAction;
use bariew\postModule\models\Item;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class DefaultController extends ItemController
{
    public $modelName = 'Item';
    public function actions()
    {
        return [
            'index' => IndexAction::className(),
            'view'  => ViewAction::className(),
        ];
    }
}
