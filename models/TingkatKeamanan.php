<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tingkat_keamanan".
 *
 * @property integer $id
 * @property string $nama_tingkat
 * @property integer $nilai_tingkat
 */
class TingkatKeamanan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tingkat_keamanan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_tingkat', 'nilai_tingkat'], 'required'],
            [['nilai_tingkat'], 'integer'],
            [['nama_tingkat'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_tingkat' => 'Nama Tingkat',
            'nilai_tingkat' => 'Nilai Tingkat',
        ];
    }
    
    public static function listKeamanan() {
        $dropOptions = TingkatKeamanan::find()->asArray()->all();
        return ArrayHelper::map($dropOptions, 'id', 'nama_tingkat');
    }
}
