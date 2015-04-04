<?php
/**
 * Model class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\postModule\models;

use bariew\postModule\Module;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Searches post items.
 * 
 * 
 * @example
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class SearchItem extends Item
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
            [['id', 'is_active'], 'integer'],
            [['title', 'brief', 'content', 'image', 'created_at'], 'safe'],
            [['user_id'], 'integer', 'on' => self::SCENARIO_ADMIN],
            [['category_id'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $model = Module::getModel($this, 'Item');
        $query = $model::find()->andFilterWhere(['user_id' => $this->user_id]);
        $dataProvider = new ActiveDataProvider(compact('query'));
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
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
