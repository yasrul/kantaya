<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\models\KecepatanSampai;
use app\models\TingkatKeamanan;
use app\models\UnitKerja;

/* @var $this yii\web\View */
/* @var $modelSurat app\models\Surat */
/* @var $modelTujuan app\models\TujuanSurat */
/* @var $modelRegin app\models\Regin */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="surat-masuk-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($modelSurat, 'no_surat')->textInput(['maxLength'=>true, 'style'=>'width : 500px']) ?>
    <?= $form->field($modelSurat, 'tgl_surat')->widget(DatePicker::className(), [
        'options' => ['placeholder' => '[ Tanggal Surat ]', 'style' => 'width : 300px'],
        'pluginOptions' => [
            'autoclose' => TRUE,
            'format' => 'yyyy-mm-dd'
        ],
        'removeButton' => false
    ]) ?>
    <?= $form->field($modelSurat, 'perihal')->textarea(['row'=>'2', 'style'=>'width : 500px']) ?>
    <?= $form->field($modelSurat, 'lampiran')->textInput(['maxLength'=>true, 'style'=>'width : 500px']) ?>
    <?= $form->field($modelSurat, 'kecepatan_sampai')->dropDownList(KecepatanSampai::listKecepatan(), [
        'prompt' => '[ Pilih Kecepatan Sampai ]',
        'style' => 'width:300px',
    ]) ?>
    <?= $form->field($modelSurat, 'tingkat_keamanan')->dropDownList(TingkatKeamanan::listKeamanan(), [
        'prompt' => '[ Pilih Tingkat Keamanan ]',
        'style' => 'width : 300px',
    ]) ?>
    <?= $form->field($modelSurat, 'file_arsip')->textInput() ?>
    <?= $form->field($modelSurat, 'id_pengirim')->widget(Select2::className(), [
        'data' => UnitKerja::listUnit(Yii::$app->user->identity->unit_id),
        'options' => ['placeholder' => '[ Pilih Pengirim ]'],
        'pluginOptions' => ['allowClear' => true, 'width'=>'500px']
    ]) ?>
    <?= $form->field($modelSurat, 'pengirim_manual')->textInput(['maxLength'=>true, 'style'=>'width : 500px']) ?>
    <?= $form->field($modelSurat, 'alamat_manual')->textInput(['maxLength'=>true, 'style'=>'width : 500px']) ?>
    
    <?= $form->field($modelTujuan, 'id_penerima')->widget(Select2::className(), [
        'data' => UnitKerja::listUnit(Yii::$app->user->identity->unit_id),
        'options' => ['placeholder' => '[ Pilih Penerima ]'],
        'pluginOptions' => ['allowClear' => TRUE, 'width'=>'500px']
    ]) ?>
    <?= $form->field($modelTujuan, 'penerima_manual')->textInput(['maxLength'=>true, 'style'=>'width : 500px']) ?>
    <?= $form->field($modelTujuan, 'alamat_manual')->textInput(['maxLength'=>true, 'style'=>'width : 500px']) ?>
    
    <?= $form->field($modelRegin, 'no_agenda')->textInput(['maxLength'=>true, 'style'=>'width : 500px']) ?>
    <?= $form->field($modelRegin, 'kode')->textInput(['maxLength' => true, 'style' => 'width : 300px']) ?>
    <?= $form->field($modelRegin, 'tgl_terima')->widget(DatePicker::className(), [
        'options' => ['placeholder' => '[ Tanggal Terima ]', 'style' => 'width : 300px'],
        'pluginOptions' => [
            'autoclose' => TRUE,
            'format' => 'yyyy-mm-dd'
        ],
        'removeButton' => false
    ]) ?>
    
    <div class="form-group">
        <?= Html::submitButton($modelSurat->isNewRecord ? 'Create' : 'Update', ['class'=>$modelSurat->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

