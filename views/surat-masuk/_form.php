<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\file\FileInput;
//use wbraganca\dynamicform\DynamicFormWidget;

use app\models\KecepatanSampai;
use app\models\TingkatKeamanan;
use app\models\UnitKerja;

/* @var $this yii\web\View */
/* @var $modelSurat app\models\Surat */
/* @var $modelTujuan app\models\SuratTujuan */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="surat-masuk-form">
    <?php $form = ActiveForm::begin(['id' => 'surat-masuk-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($modelSurat, 'id_dari')->widget(Select2::className(), [
        'data' => UnitKerja::listUnit(1),
        'options' => ['placeholder' => '[ Surat Dari... ]'],
        'pluginOptions' => ['allowClear' => true, 'width'=>'500px']
    ]) ?>
    <?= $form->field($modelSurat, 'no_surat')->textInput(['maxLength'=>true, 'style'=>'width : 500px']) ?>
    <?= $form->field($modelSurat, 'tgl_surat')->widget(DatePicker::className(), [
        'options' => ['placeholder' => '[ Tanggal Surat ]', 'style' => 'width : 300px'],
        'pluginOptions' => [
            'autoclose' => TRUE,
            'format' => 'yyyy-mm-dd'
        ],
        'removeButton' => false
    ]) ?>
    <?= $form->field($modelTujuan, 'tgl_diterima')->widget(DatePicker::className(), [
        'options' => ['placeholder' => '[ Tanggal Diterima ]', 'style' => 'width : 300px'],
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
    
    <?php if ($modelSurat->isNewRecord) : ?>
    <?= $form->field($modelSurat, 'filesup[]')->widget(FileInput::className(), [
        'options' => ['multiple' => TRUE,'accept' => '*/*'],
        'pluginOptions' => [
            'allowedFileExtensions'=>['jpg','jpeg','png','pdf','zip','rar'], 
            'showUpload'=>FALSE,
            'showCaption'=>TRUE,
            'showRemove'=>true,
            'style' => 'width : 500px'
        ]
    ]) ?>
    <?php else : ?>
    <?= $form->field($modelSurat, 'filesup[]')->widget(FileInput::className(), [
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'showUpload' => FALSE,
            'initialPreview' => $urlFiles,
            'initialPreviewAsData'=>true,
            'overwriteInitial'=>false,
            'initialPreviewConfig' => $previewConfig,
            'previewFileType' => 'any',
        ]
    ]); ?>
    <?php endif ?>
    
    <?= $form->field($modelSurat, 'id_pengirim')->widget(Select2::className(), [
        'data' => UnitKerja::listUnit(1),
        'options' => ['placeholder' => '[ Pilih Pengirim ]'],
        'pluginOptions' => ['allowClear' => true, 'width'=>'500px']
    ]) ?>
    <!--
    <?php echo Collapse::widget([
        'items' => [
            [
                'label' => 'Pengirim Manual',
                'content' => [
                    $form->field($modelSurat, 'pengirim_manual')->textInput(['maxLength'=>true, 'style'=>'width : 500px']),
                    $form->field($modelSurat, 'alamat_manual')->textInput(['maxLength'=>true, 'style'=>'width : 500px'])
                ]
            ]
        ]
    ]) ?>
    -->  
    <div class="form-group">
        <?= Html::submitButton($modelSurat->isNewRecord ? 'Create' : 'Update', ['class'=>$modelSurat->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

