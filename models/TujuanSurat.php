<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tujuan_surat".
 *
 * @property integer $id
 * @property integer $id_surat
 * @property integer $id_penerima
 * @property string $penerima_manual
 * @property string $alamat_manual
 * @property integer $status_tujuan
 * @property integer $status_baca
 * @property string $tgl_diterima
 * @property string $tgl_diteruskan
 * 
 */
class TujuanSurat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tujuan_surat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_surat', 'status'], 'required'],
            [['id_surat', 'id_penerima', 'status_tujuan', 'status_baca'], 'integer'],
            [['penerima_manual', 'alamat_manual'], 'string', 'max' => 255],
            [['id', 'tgl_diterima', 'tgl_diteruskan'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_surat' => 'Id Surat',
            'id_penerima' => 'Id Penerima',
            'penerima_manual' => 'Penerima Manual',
            'alamat_manual' => 'Alamat Manual',
            'status_tujuan' => 'Status Tujuan',
            'status_baca' => 'Status Baca',
            'tgl_diterima' => 'Tanggal Diterima',
            'tgl_diteruskan' => 'Tanggal Diteruskan',
        ];
    }
    
    public function getSurat() 
    {
        return $this->hasOne(Surat::className(), ['id' => 'id_surat']);
        
    }
    
    public function getPenerima()
    {
        return $this->hasOne(UnitKerja::className(), ['id' => 'id_penerima']);
    }
}
