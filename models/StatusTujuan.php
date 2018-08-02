<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "status_tujuan".
 *
 * @property int $id
 * @property string $status_name
 * @property int $status_value
 */
class StatusTujuan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status_tujuan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_name', 'status_value'], 'required'],
            [['status_value'], 'integer'],
            [['status_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_name' => 'Status Name',
            'status_value' => 'Status Value',
        ];
    }
    
    public static function listStatusTujuan() {
        $droption = StatusTujuan::find()->asArray()->all();
        return ArrayHelper::map($droption, 'id', 'status_name');
    }
}
