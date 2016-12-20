<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "regin".
 *
 * @property integer $id
 * @property integer $id_unit
 * @property integer $id_surat
 * @property string $no_agenda
 * @property string $kode
 * @property string $tgl_terima
 * @property integer $status
 */
class Regin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_unit', 'id_surat', 'status'], 'required'],
            [['id_unit', 'id_surat', 'status'], 'integer'],
            [['tgl_terima'], 'safe'],
            [['no_agenda'], 'string', 'max' => 30],
            [['kode'], 'string', 'max' => 10],
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
            'no_agenda' => 'No Agenda',
            'kode' => 'Kode',
            'tgl_terima' => 'Tgl Terima',
            'status' => 'Status',
        ];
    }
}
