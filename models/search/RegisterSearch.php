<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Register;

/**
 * RegisterSearch represents the model behind the search form about `app\models\Register`.
 */
class RegisterSearch extends Register
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_unit', 'id_surat', 'status_surat', 'status_reg'], 'integer'],
            [['tgl_trans', 'no_agenda', 'kode'], 'safe'],
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
        $query = Register::find();

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
            'id_unit' => $this->id_unit,
            'id_surat' => $this->id_surat,
            'tgl_trans' => $this->tgl_trans,
            'status_surat' => $this->status_surat,
            'status_reg' => $this->status_reg,
        ]);

        $query->andFilterWhere(['like', 'no_agenda', $this->no_agenda])
            ->andFilterWhere(['like', 'kode', $this->kode]);

        return $dataProvider;
    }
}
