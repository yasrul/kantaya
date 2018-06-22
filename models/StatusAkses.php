<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status_akses".
 *
 * @property integer $id
 * @property integer $status_value
 * @property string $status_name
 */
class StatusAkses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status_akses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_value', 'status_name'], 'required'],
            [['status_value'], 'integer'],
            [['status_name'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_value' => 'Status Value',
            'status_name' => 'Status Name',
        ];
    }
}
