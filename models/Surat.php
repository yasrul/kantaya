<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\models\KecepatanSampai;
use app\models\TingkatKeamanan;
use app\models\Disposisi;
use app\models\DisposisiTujuan;
use app\models\SuratTujuan;

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
 * @property integer $id_pengirim
 * @property string $pengirim_manual
 * @property string $alamat_manual
 * @property integer $status_akses
 * @property string $dokumen
 * @property string $id_perekam
 * @property TujuanSurat[] $tujuan
 */
class Surat extends \yii\db\ActiveRecord
{
    public $filesup;
    
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
            [['id_dari','no_surat', 'tgl_surat', 'perihal'], 'required'],
            [['tgl_surat'], 'safe'],
            [['kecepatan_sampai', 'tingkat_keamanan', 'id_pengirim','status_akses'], 'integer'],
            [['no_surat', 'perihal', 'alamat_manual'], 'string', 'max' => 255],
            [['lampiran', 'pengirim_manual'], 'string', 'max' => 100],
            [['dokumen', 'id_perekam'], 'safe'],
            [['filesup'], 'file', 'extensions' => ['jpg','jpeg','pdf','zip','rar'],
                'maxSize' => 1024*1024,
                'skipOnEmpty' => TRUE,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_dari' => 'Dari',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'perihal' => 'Perihal',
            'lampiran' => 'Lampiran',
            'kecepatan_sampai' => 'Kecepatan Sampai',
            'tingkat_keamanan' => 'Tingkat Keamanan',
            'id_pengirim' => 'Pengirim',
            'pengirim_manual' => 'Pengirim Manual',
            'alamat_manual' => 'Alamat Manual',
            'status_akses' => 'Status Akses',
            'dokumen' => 'Nama File Dokumen',
            'filesup' => 'Upload Dokumen'
        ];
    }
    
    public function getKecepatanSampai() {
        return $this->hasOne(KecepatanSampai::className(), ['id' => 'kecepatan_sampai']);
    }
    
    public function getTingkatKeamanan() {
        return $this->hasOne(TingkatKeamanan::className(), ['id' => 'tingkat_keamanan']);
    }
    
    public function getTujuan() {
        return $this->hasMany(SuratTujuan::className(), ['id_surat' => 'id' ]);
    }
    
    public function setTujuan($value) {
        $this->loadRelated('tujuan', $value);
    }

    public function getPengirim() {
        return $this->hasOne(UnitKerja::className(), ['id' => 'id_pengirim']);
    }
    
    public function getDari() {
        return $this->hasOne(UnitKerja::className(), ['id' => 'id_dari']);
    }
    
    public function getStatusAkses() {
        return $this->hasOne(StatusAkses::className(), ['id' => 'status_akses']);
    }
    
    public function getDisposisi() {
        return $this->hasMany(Disposisi::className(), ['id_surat' => 'id']);
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
    
    public function uploadFiles() {
        $filesup = UploadedFile::getInstances($this, 'filesup');
        
        if (! isset($filesup)) {
            return FALSE;
        } else {
            $dokumen = '';
            foreach ($filesup as $fileup) {
                $filename = $fileup->name;
                $path = Yii::$app->basePath.'/web/docfiles/'.$filename;
                $count = 0;
                while (file_exists($path)) {
                    $count++;
                    $filename = $fileup->baseName.'_'.$count.'.'.$fileup->extension;
                    $path = Yii::$app->basePath.'/web/docfiles/'.$filename;                      
                }
                $dokumen .= $filename.'//';
                $fileup->saveAs($path);
            }
            $this->dokumen = $dokumen;
        }
        
        return TRUE;       
    }
    
    public function getPathFile() {
        return isset($this->doc_appfilename) ? Yii::getAlias('@app/docfiles/').$this->doc_appfilename : null;
    }
    
    public function getUrlFile() {
        return isset($this->doc_appfilename) ? Yii::$app->params['uploadUrl'].$this->doc_appfilename : null;
    }
    
    public function deleteFile() {
        $file = $this->getPathFile();
        
        if(empty($file) || !file_exists($file)) {
            return FALSE;
        }
        
        if(!unlink($file)) {
            return FALSE;
        }
        
        $this->doc_srcfilename = null;
        $this->doc_appfilename = NULL;
        
        return true;
    }
}
