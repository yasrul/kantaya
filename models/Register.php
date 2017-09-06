<?php

namespace app\models;

use Yii;
use app\models\StatusSurat;
use app\models\StatusKirim;

/**
 * This is the model class for table "register".
 *
 * @property integer $id
 * @property integer $id_unit
 * @property integer $id_surat
 * @property string $tgl_trans
 * @property string $no_agenda
 * @property string $kode
 * @property integer $status_surat
 * @property integer $status_register
 */
class Register extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'register';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_unit', 'id_surat', 'tgl_trans', 'status_surat', 'status_reg'], 'required'],
            [['id_unit', 'id_surat', 'status_surat', 'status_reg'], 'integer'],
            [['tgl_trans'], 'safe'],
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
            'tgl_trans' => 'Tgl Trans',
            'no_agenda' => 'No Agenda',
            'kode' => 'Kode',
            'status_surat' => 'Status Surat',
            'status_reg' => 'Status Register',
        ];
    }
    
    public function getStatusSurat() {
        return $this->hasOne(StatusSurat::className(), ['id' => 'status_surat']);
    }
    
    public function getStatusRegister() {
        return $this->hasOne(StatusRegister::className(), ['id' => 'status_register']);
    }
}
