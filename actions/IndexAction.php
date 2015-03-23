<?php
/**
 * IndexAction class file.
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
class IndexAction extends Action
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        /**
         * @var SearchItem $searchModel
         */
        $searchModel = $this->controller->findModel(null, true);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->controller->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}