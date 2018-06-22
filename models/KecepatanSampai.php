<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "kecepatan_sampai".
 *
 * @property integer $id
 * @property string $nama_kecepatan
 * @property integer $nilai_kecepatan
 */
class KecepatanSampai extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kecepatan_sampai';
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
    
    public static function listKecepatan() {
        $dropOption = KecepatanSampai::find()->asArray()->all();
        return ArrayHelper::map($dropOption, 'id', 'nama_kecepatan');
    }
}
