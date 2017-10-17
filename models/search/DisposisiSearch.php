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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_surat', 'id_pemberi', 'id_intruksi'], 'integer'],
            [['tgl_disposisi', 'tgl_selesai', 'pesan'], 'safe'],
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
            $query = Disposisi::find()->where(['disposisi_tujuan.id_penerima' => Yii::$app->user->id])->orderBy('tgl_disposisi Desc')->joinWith('tujuan, surat');
        } elseif ($io == 'out') {
            $query = Disposisi::find()->where(['id_pemberi' => Yii::$app->user->id])->orderBy('tgl_disposisi Desc')->joinWith('tujuan, surat');   
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
            'id_pemberi' => $this->id_pemberi,
            'tgl_disposisi' => $this->tgl_disposisi,
            'tgl_selesai' => $this->tgl_selesai,
            'id_intruksi' => $this->id_intruksi,
        ]);

        $query->andFilterWhere(['like', 'pesan', $this->pesan]);

        return $dataProvider;
    }
}
