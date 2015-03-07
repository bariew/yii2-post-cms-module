<?php
/**
 * ImageGallery class file.
 * @copyright (c) 2015, Bariev Pavel
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\postModule\widgets;

use yii\base\Widget;
use bariew\postModule\models\Item;

/**
 * For rendering image gallery for post Item model.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class ImageGallery extends Widget
{
    /**
     * @var Item $model
     */
    public $model;

    /**
     * @var string thumbnail name (like thumbnail1, thumbnail2)
     * @see FileBehavior::imageSettings() keys
     */
    public $field;

    /**
     * @var string view file name.
     */
    public $viewName = 'image_gallery';

    public $admin = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render($this->viewName, [
            'model' => $this->model,
            'items' => $this->model->linkList($this->field),
            'admin' => $this->admin
        ]);
    }
}