<?php

namespace bariew\postModule\models;

use bariew\postModule\Module;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchCategory represents the model behind the search form about `bariew\postModule\models\Category`.
 */
class SearchCategory extends Category
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
        $model = Module::getModel($this, 'Category');
        $query = $model::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->andFilterWhere(['is_active' => $this->is_active]);
            return $dataProvider;
        }

        $query->andFilterWhere([
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
