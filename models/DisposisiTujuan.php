<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disposisi_tujuan".
 *
 * @property integer $id
 * @property integer $id_disposisi
 * @property integer $id_penerima
 * @property string $tgl_diterima
 * @property string $keterangan
 */
class DisposisiTujuan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disposisi_tujuan';
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
            [['keterangan'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_disposisi' => 'Id Disposisi',
            'id_penerima' => 'Id Penerima',
            'tgl_diterima' => 'Tgl Diterima',
            'keterangan' => 'Keterangan',
        ];
    }
}
