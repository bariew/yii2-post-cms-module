<?php
/**
 * ItemSearch class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\postModule\models;

use bariew\postModule\Module;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Searches post items.
 * 
 * 
 * @example
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class ItemSearch extends Item
{
    public $category_id;

    public static function tableName()
    {
        return Module::getModel(static::className(), 'Item')->tableName();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_active', 'owner_id', 'category_id'], 'integer'],
            [['title', 'brief', 'content', 'image', 'created_at'], 'safe'],
            [['is_active'], 'boolean'],
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
        /** @var Item $model */
        $model = Module::getModel($this, 'Item');
        /**
         * @var ActiveQuery $query
         */
        $query = $model->search();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'brief', $this->brief])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere([
                'like', 'DATE_FORMAT(FROM_UNIXTIME(created_at), "%Y-%m-%d")', $this->created_at
            ])
            ;
        if ($this->category_id) {
            $t = $this->tableName();
            $relation = \bariew\postModule\Module::getModel($this, 'CategoryToItem')->tableName();
            $query->innerJoin($relation, "$relation.item_id = $t.id")
                ->andWhere(["$relation.category_id" => $this->category_id]);
        }

        return $dataProvider;
    }
}
