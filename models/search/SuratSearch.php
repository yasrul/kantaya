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
    public $pengirim;
    public $dari;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','id_dari','kecepatan_sampai', 'tingkat_keamanan', 'id_pengirim', 'status_akses'], 'integer'],
            [['no_surat', 'tgl_surat','dari', 'perihal', 'lampiran', 'pengirim', 'pengirim_manual', 'alamat_manual', 'id_perekam'], 'safe'],
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
    public function search($params, $io)
    {
        if ($io == 'in') {
            $query = Surat::find()->where(['surat_tujuan.id_penerima' => Yii::$app->user->identity->unit_id])->orderBy('tgl_surat Desc')->joinWith(['tujuan']);
        } elseif ($io == 'out') {
            $query = Surat::find()->where(['id_pengirim' => Yii::$app->user->identity->unit_id])->orderBy('tgl_surat Desc')->joinWith(['tujuan']);
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
            //'id_dari' => $this->id_dari,
            'tgl_surat' => $this->tgl_surat,
            'kecepatan_sampai' => $this->kecepatan_sampai,
            'tingkat_keamanan' => $this->tingkat_keamanan,
            'id_pengirim' => $this->id_pengirim,
            'status_akses' => $this->status_akses,
        ]);

        $query->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            ->andFilterWhere(['like','unit_kerja.unit_kerja', $this->dari])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            //->andFilterWhere(['like', 'file_arsip', $this->file_arsip])
            ->andFilterWhere(['like', 'unit_kerja.unit_kerja', $this->pengirim])
            ->andFilterWhere(['like', 'pengirim_manual', $this->pengirim_manual])
            ->andFilterWhere(['like', 'alamat_manual', $this->alamat_manual]);

        return $dataProvider;
    }
}
