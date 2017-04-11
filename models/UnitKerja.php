<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "unit_kerja".
 *
 * @property integer $id
 * @property string $unit_kerja
 * @property integer $id_induk
 */
class UnitKerja extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit_kerja';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'unit_kerja'], 'required'],
            [['id', 'id_induk'], 'integer'],
            [['unit_kerja'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_kerja' => 'Unit Kerja',
            'id_induk' => 'Id Induk',
        ];
    }
    
    public static function listUnit($idInduk) {
        $dropOptions = UnitKerja::find()->where(['id_induk' => $idInduk])->asArray()->all();
        return ArrayHelper::map($dropOptions, 'id', 'unit_kerja');
    }
}
