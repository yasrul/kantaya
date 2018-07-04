<?php

namespace app\models;

use Yii;
use app\models\UnitKerja;

/**
 * This is the model class for table "disposisi".
 *
 * @property integer $id
 * @property integer $id_surat
 * @property integer $id_pemberi
 * @property string $tgl_disposisi
 * @property string $tgl_selesai
 * @property integer $id_intruksi
 * @property string $pesan
 */
class Disposisi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disposisi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_surat', 'id_pemberi', 'tgl_disposisi'], 'required'],
            [['id_surat', 'id_pemberi', 'id_intruksi'], 'integer'],
            [['tgl_disposisi', 'tgl_selesai'], 'safe'],
            [['pesan'], 'string', 'max' => 500],
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
            'id_pemberi' => 'Id Pemberi',
            'tgl_disposisi' => 'Tgl Disposisi',
            'tgl_selesai' => 'Tgl Selesai',
            'id_intruksi' => 'Id Intruksi',
            'pesan' => 'Pesan',
        ];
    }
    
    public function getSurat() {
        return $this->hasOne(Surat::className(), ['id' => 'id_surat']);
    }

    public function getTujuan() {
        return $this->hasMany(DisposisiTujuan::className(), ['id_disposisi' => 'id']);
    }
    
    public function getPemberi() {
        return $this->hasOne(UnitKerja::className(), ['id' =>'id_pemberi']);
    }
}
