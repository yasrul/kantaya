<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "regout".
 *
 * @property integer $id
 * @property integer $id_unit
 * @property integer $id_surat
 * @property string $tgl_kirim
 * @property integer $status
 */
class Regout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_unit', 'id_surat', 'status'], 'required'],
            [['id_unit', 'id_surat', 'status'], 'integer'],
            [['tgl_kirim'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_unit' => 'Id Unit',
            'id_surat' => 'Id Surat',
            'tgl_kirim' => 'Tgl Kirim',
            'status' => 'Status',
        ];
    }
}
