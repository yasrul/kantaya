<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "surat".
 *
 * @property integer $id
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $perihal
 * @property string $lampiran
 * @property integer $kecepatan_tanggapan
 * @property integer $tingkat_keamanan
 * @property string $file_arsip
 * @property integer $id_pengirim
 * @property string $pengirim_manual
 * @property string $alamat_manual
 */
class Surat extends \yii\db\ActiveRecord
{
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
            [['kecepatan_tanggapan', 'tingkat_keamanan', 'id_pengirim'], 'integer'],
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
            'kecepatan_tanggapan' => 'Kecepatan Tanggapan',
            'tingkat_keamanan' => 'Tingkat Keamanan',
            'file_arsip' => 'File Arsip',
            'id_pengirim' => 'Id Pengirim',
            'pengirim_manual' => 'Pengirim Manual',
            'alamat_manual' => 'Alamat Manual',
        ];
    }
}
