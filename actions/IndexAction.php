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
    public $view = 'index';
    public $ajaxView = 'index-ajax';
    public $params = [];
    public $search = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        /**
         * @var SearchItem $searchModel
         */
        $searchModel = $this->controller->findModel(null, true);
        $data = array_merge([
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(
                array_merge(Yii::$app->request->queryParams, $this->search
            )),
        ], $this->params);

        return Yii::$app->request->isAjax
            ? $this->controller->renderPartial($this->ajaxView, $data)
            : $this->controller->render($this->view, $data);
    }
}