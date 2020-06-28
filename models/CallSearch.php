<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Call;

/**
 * CallSearch represents the model behind the search form of `app\models\Call`.
 */
class CallSearch extends Call
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'account_id', 'mentor_id', 'success'], 'integer'],
            ['cost_per_minute', 'double'],
            [['sip_id', 'created_at', 'city', 'duration'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Call::find();

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
            'id'              => $this->id,
            'account_id'      => $this->account_id,
            'mentor_id'       => $this->mentor_id,
            'created_at'      => $this->created_at,
            'success'         => $this->success,
            'cost_per_minute' => $this->cost_per_minute,
            'duration'        => $this->duration,
        ]);

        $query->andFilterWhere(['like', 'sip_id', $this->sip_id])
            ->andFilterWhere(['like', 'city', $this->city]);

        return $dataProvider;
    }
}
