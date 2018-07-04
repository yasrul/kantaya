<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Disposisi;

/**
 * DisposisiSearch represents the model behind the search form about `app\models\Disposisi`.
 */
class DisposisiSearch extends Disposisi
{
    public $no_surat;
    public $tgl_surat;
    public $perihal;
    public $pemberi;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_surat', 'id_pemberi', 'id_intruksi'], 'integer'],
            [['no_surat','tgl_disposisi', 'tgl_selesai', 'pesan','pemberi'], 'safe'],
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
            $query = Disposisi::find()->where(['disposisi_tujuan.id_penerima' => Yii::$app->user->identity->unit_id])->orderBy('tgl_disposisi Desc')->joinWith(['tujuan','surat','pemberi']);
        } elseif ($io == 'out') {
            $query = Disposisi::find()->where(['id_pemberi' => Yii::$app->user->identity->unit_id])->orderBy('tgl_disposisi Desc')->joinWith(['tujuan','surat','pemberi']);   
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
            'id_surat' => $this->id_surat,
            'unit_kerja.unit_kerja' => $this->pemberi,
            'tgl_disposisi' => $this->tgl_disposisi,
            'tgl_selesai' => $this->tgl_selesai,
            'id_intruksi' => $this->id_intruksi,
            'surat.no_surat' => $this->no_surat,
            'surat.tgl_surat' => $this->tgl_surat
            
        ]);

        $query->andFilterWhere(['like', 'pesan', $this->pesan]);
        $query->andFilterWhere(['like', 'surat.perihal', $this->perihal]);

        return $dataProvider;
    }
}
