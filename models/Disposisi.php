<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disposisi".
 *
 * @property integer $id
 * @property integer $id_regin
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
            [['id_regin', 'id_pemberi', 'tgl_disposisi', 'id_intruksi'], 'required'],
            [['id_regin', 'id_pemberi', 'id_intruksi'], 'integer'],
            [['tgl_disposisi', 'tgl_selesai'], 'safe'],
            [['pesan'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_regin' => 'Id Regin',
            'id_pemberi' => 'Id Pemberi',
            'tgl_disposisi' => 'Tgl Disposisi',
            'tgl_selesai' => 'Tgl Selesai',
            'id_intruksi' => 'Id Intruksi',
            'pesan' => 'Pesan',
        ];
    }
}
