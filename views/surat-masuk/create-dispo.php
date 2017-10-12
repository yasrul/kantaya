<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $modelDispo app\models\Disposisi */
/* @var $modelDispoTujuan app\models\DisposisiTujuan */
/* @var $id_surat */

$this->title = 'Create Disposisi';
$this->params['breadcrumbs'][] = ['label'=>'View Surat', 'url'=>['view', 'id' => $id_surat]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disposisi-create">
    <h1><?= Html::encode($this->title)?></h1>
    
    <?php $form = ActiveForm::begin(['id' => 'disposisi-create-form']); ?>
    <?= $form->field($modelDispo, 'tgl_disposisi')->widget(DatePicker::className(), [
        'options' => ['placeholder' => '[ Tanggal Disposisi ]', 'style' => 'width : 300px'],
        'pluginOptions' => [
            'autoclose' => TRUE,
            'format' => 'yyyy-mm-dd'
        ],
        'removeButton' => false
    ]) ?>
    <?= $form->field($modelDispo, 'pesan')->textarea(['row'=>'2', 'style'=>'width : 500px']) ?>
    <?= $form->field($modelDispo, 'tgl_selesai')->widget(DatePicker::className(), [
        'options' => ['placeholder' => '[ Tanggal Selesai ]', 'style' => 'width : 300px'],
        'pluginOptions' => [
            'autoclose' => TRUE,
            'format' => 'yyyy-mm-dd'
        ],
        'removeButton' => false
    ]) ?>
    <?php ActiveForm::end(); ?>
</div>