<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OfflineActivity;

/**
 * OfflineActivitySearch represents the model behind the search form about `common\models\OfflineActivity`.
 */
class OfflineActivitySearch extends OfflineActivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_id', 'end_time', 'people_num', 'benefit_walk_min', 'benefit_walk_max', 'created_at', 'updated_at'], 'integer'],
            [['location', 'en_location', 'desc', 'en_desc'], 'safe'],
            [['price'], 'number'],
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
        $query = OfflineActivity::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'activity_id' => $this->activity_id,
            'end_time' => $this->end_time,
            'people_num' => $this->people_num,
            'price' => $this->price,
            'benefit_walk_min' => $this->benefit_walk_min,
            'benefit_walk_max' => $this->benefit_walk_max,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'en_location', $this->en_location])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'en_desc', $this->en_desc]);

        return $dataProvider;
    }
}
