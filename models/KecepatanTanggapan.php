<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kecepatan_tanggapan".
 *
 * @property integer $id
 * @property string $nama_kecepatan
 * @property integer $nilai_kecepatan
 */
class KecepatanTanggapan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kecepatan_tanggapan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_kecepatan', 'nilai_kecepatan'], 'required'],
            [['nilai_kecepatan'], 'integer'],
            [['nama_kecepatan'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_kecepatan' => 'Nama Kecepatan',
            'nilai_kecepatan' => 'Nilai Kecepatan',
        ];
    }
}
