<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TujuanSurat;

/**
 * TujuanSuratSearch represents the model behind the search form about `app\models\TujuanSurat`.
 */
class TujuanSuratSearch extends TujuanSurat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_surat', 'id_penerima', 'status_tujuan'], 'integer'],
            [['penerima_manual', 'alamat_manual'], 'safe'],
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
        $query = TujuanSurat::find();

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
            'id_surat' => $this->id_surat,
            'id_penerima' => $this->id_penerima,
            'status_tujuan' => $this->status_tujuan,
        ]);

        $query->andFilterWhere(['like', 'penerima_manual', $this->penerima_manual])
            ->andFilterWhere(['like', 'alamat_manual', $this->alamat_manual]);

        return $dataProvider;
    }
}
