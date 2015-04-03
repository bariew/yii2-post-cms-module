<?php
/**
 * Model class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\postModule\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bariew\postModule\models\Item;
use yii\db\ActiveRecord;

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
        $class = str_replace('SearchItem', 'Item', get_called_class());
        return $class::tableName();
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
        /**
         * @var ActiveRecord $class
         */
        $class = str_replace('SearchItem', 'Item', get_class($this));
        $query = $class::find()->andFilterWhere(['user_id' => $this->user_id]);
        $dataProvider = new ActiveDataProvider(compact('query'));
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        //print_r($this->attributes);exit;

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
