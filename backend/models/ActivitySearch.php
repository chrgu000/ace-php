<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Activity;

/**
 * ActivitySearch represents the model behind the search form about `common\models\Activity`.
 */
class ActivitySearch extends Activity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'topic_id', 'start_time', 'end_time', 'join_type', 'people_num', 'created_at', 'updated_at', 'benefit_walk', 'benefit_run', 'benefit_bike'], 'integer'],
            [['cover', 'title', 'en_title', 'location', 'en_location', 'desc', 'en_desc'], 'safe'],
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
        $query = Activity::find();

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
            'topic_id' => $this->topic_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'join_type' => $this->join_type,
            'people_num' => $this->people_num,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'benefit_walk' => $this->benefit_walk,
            'benefit_run' => $this->benefit_run,
            'benefit_bike' => $this->benefit_bike,
        ]);

        $query->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'en_title', $this->en_title])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'en_location', $this->en_location])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'en_desc', $this->en_desc]);

        return $dataProvider;
    }
}
