<?php

namespace app\models;

use Yii;
use app\models\KecepatanSampai;
use app\models\TingkatKeamanan;

/**
 * This is the model class for table "surat".
 *
 * @property integer $id
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $perihal
 * @property string $lampiran
 * @property integer $kecepatan_sampai
 * @property integer $tingkat_keamanan
 * @property string $file_arsip
 * @property integer $id_pengirim
 * @property string $pengirim_manual
 * @property string $alamat_manual
 * 
 * @property TujuanSurat[] $tujuan
 */
class Surat extends \yii\db\ActiveRecord
{
    use \mdm\behaviors\ar\RelationTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'surat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_surat', 'tgl_surat', 'perihal'], 'required'],
            [['tgl_surat'], 'safe'],
            [['kecepatan_sampai', 'tingkat_keamanan', 'id_pengirim'], 'integer'],
            [['no_surat', 'perihal', 'file_arsip', 'alamat_manual'], 'string', 'max' => 255],
            [['lampiran', 'pengirim_manual'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'perihal' => 'Perihal',
            'lampiran' => 'Lampiran',
            'kecepatan_sampai' => 'Kecepatan Sampai',
            'tingkat_keamanan' => 'Tingkat Keamanan',
            'file_arsip' => 'File Arsip',
            'id_pengirim' => 'Id Pengirim',
            'pengirim_manual' => 'Pengirim Manual',
            'alamat_manual' => 'Alamat Manual',
        ];
    }
    
    public function getKecepatanSampai() {
        return $this->hasOne(KecepatanSampai::className(), ['id' => 'kecepatan_sampai']);
    }
    
    public function getTingkatKeamanan() {
        return $this->hasOne(TingkatKeamanan::className(), ['id' => 'tingkat_keamanan']);
    }
    
    public function getTujuan() {
        return $this->hasMany(TujuanSurat::className(), ['id_surat' => 'id' ]);
    }
    
    public function setTujuan($value) {
        $this->loadRelated('tujuan', $value);
    }
    
    public function getRegister() {
        return $this->hasMany(Register::className(), ['id_surat' => 'id']);
    }
    
    public function setRegister($value) {
        $this->loadRelated('register', $value);
    }

    public function getPengirim() {
        return $this->hasOne(UnitKerja::className(), ['id' => 'id_pengirim']);
    }

    public static function maxIdSurat($tglSurat) {
        $idUnit = Yii::$app->user->identity->unit_id;
        $th = Yii::$app->formatter->asDate($tglSurat,'yy');
        
        $q = 'select max(id) from surat where substring(id, 1,4) = :unitTahun';
        $cmd = Yii::$app->db->createCommand($q);
        $cmd->bindValue(':unitTahun', $idUnit.$th,\PDO::PARAM_STR);
        $maxId = $cmd->queryScalar();
        
        if ($maxId == NULL) {
            $maxId = 1;
        } else {
            $maxId = substr($maxId, 4, 4)+1;
        }
        return $idUnit.$th.sprintf("%04d",$maxId);
    }
}
