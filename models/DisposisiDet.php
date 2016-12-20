<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disposisi_det".
 *
 * @property integer $id_disposisi
 * @property integer $id_penerima
 * @property string $tgl_diterima
 */
class DisposisiDet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disposisi_det';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_disposisi', 'id_penerima'], 'required'],
            [['id_disposisi', 'id_penerima'], 'integer'],
            [['tgl_diterima'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_disposisi' => 'Id Disposisi',
            'id_penerima' => 'Id Penerima',
            'tgl_diterima' => 'Tgl Diterima',
        ];
    }
}
