<?php
/**
 * CategorySearch class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\postModule\models;

use bariew\postModule\Module;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class CategorySearch extends Category
{
    public static function tableName()
    {
        return Module::getModel(static::className(), 'Category')->tableName();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lft', 'rgt', 'depth', 'is_active'], 'integer'],
            [['is_active'], 'default', 'value' => 1],
            [['title', 'name', 'content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_ADMIN => [
                'content', 'title', 'is_active', 'name', 'image'
            ],
            self::SCENARIO_DEFAULT => [
                'content', 'title', 'is_active', 'name', 'image'
            ]
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        $model = Module::getModel($this, 'Category', ['scenario' => $this->scenario]);
        /**
         * @var ActiveQuery $query
         */
        $query = $model->search();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->andFilterWhere(['is_active' => $this->is_active]);
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['is_active' => $this->is_active])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
