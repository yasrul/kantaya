<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Surat;

/**
 * SuratSearch represents the model behind the search form about `app\models\Surat`.
 */
class SuratSearch extends Surat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kecepatan_sampai', 'tingkat_keamanan', 'id_pengirim', 'status_akses'], 'integer'],
            [['no_surat', 'tgl_surat', 'perihal', 'lampiran', 'file_arsip', 'pengirim_manual', 'alamat_manual'], 'safe'],
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
    public function search($params, $inout)
    {
        if ($inout == 'in') {
            $query = Surat::find()->where(['tujuan_surat.id_penerima' => Yii::$app->user->identity->unit_id])->orderBy('tgl_surat Asc')->joinWith(['tujuan']);
        } elseif ($inout == 'out') {
            $query = Surat::find()->where(['id_pengirim' => Yii::$app->user->identity->unit_id])->orderBy('tgl_surat Asc')->joinWith(['tujuan_surat']);
        }

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
            'tgl_surat' => $this->tgl_surat,
            'kecepatan_sampai' => $this->kecepatan_sampai,
            'tingkat_keamanan' => $this->tingkat_keamanan,
            'id_pengirim' => $this->id_pengirim,
            'status_akses' => $this->status_akses,
        ]);

        $query->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'file_arsip', $this->file_arsip])
            ->andFilterWhere(['like', 'pengirim_manual', $this->pengirim_manual])
            ->andFilterWhere(['like', 'alamat_manual', $this->alamat_manual]);

        return $dataProvider;
    }
}
